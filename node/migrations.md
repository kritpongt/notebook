### Logging & Progress `ora` + `chalk`
`npm install ora chalk`

---

มาดู debug strategy ที่ใช้ได้จริงกับ codebase นี้ — ผมจะแบ่งตาม "ระดับความลึกของปัญหา" ให้

## 🎯 Debug Pyramid (ไล่จากง่ายไปยาก)

```
       [4. Step debugger]      ← เปิดเมื่อจำเป็นจริง
      [3. Log per transform]   ← debug logic เฉพาะ
     [2. CLI flags + report]   ← debug ระดับ table
    [1. Run single table]      ← isolate ปัญหาก่อน
```

---

## Level 1: Isolate ก่อน — รัน 1 ตาราง

อย่ารัน 100 ตารางพร้อมกันแล้วงม — แยกออกมาทีละตัว

```bash
npx tsx data_migration/migrate.ts sys_user
```

**ใช้ตอน**: เห็น error ในตารางใดตารางหนึ่ง → รันแค่ตัวนั้นก่อน ตัดตัวแปร "ตารางอื่นรบกวน" ออก

---

## Level 2: CLI Diagnostic Flags — ที่ออกแบบมาเพื่อ debug

### 🔍 Dry-run — เห็นว่าจะเกิดอะไร โดยไม่เขียน DB

```bash
npx tsx data_migration/migrate.ts --dry-run --report
```

ได้ไฟล์ `reports/2026-05-18T15-30-00.json` พร้อม skip reasons + error breakdown — เปิดไฟล์อ่านได้เลย

**ใช้ตอน**: 
- เพิ่มตารางใหม่ครั้งแรก ไม่อยากเสี่ยง DB ของจริง
- หา bug ใน transform logic — `dryRun` skip ขั้น Prisma แต่ยัง iterate ทุก row ผ่าน transform

### 📊 Report only — เก็บหลักฐาน

```bash
npx tsx data_migration/migrate.ts --report
cat data_migration/reports/2026-05-18T15-30-00.json | jq '.tables[] | select(.failed > 0)'
```

**ใช้ตอน**: รันแล้วเห็น error ผ่านๆ ไป จับไม่ทัน → เปิด JSON ดู error messages ครบ พร้อม row id

### ⚡ Force — รันต่อให้รู้ว่าพังจริงไหม

```bash
npx tsx data_migration/migrate.ts --force --report
```

**ใช้ตอน**: failure rate > 10% ทำให้หยุด แต่อยากรู้ว่า table ถัดๆ ไปจะพังเหมือนกันไหม

---

## Level 3: Log per Transform — debug data ราย row

เวลาเจอ row ที่ insert ไม่ได้แต่ไม่รู้ทำไม → ใส่ log ใน `transform`

```ts
transform: (r) => {
  const id = r.sy_grp_id as number
  
  // 🔍 DEBUG — log raw input
  if (id === 999) console.log('raw:', r)
  
  const data = {
    id,
    name: truncate(r.sy_grp_name, 50) ?? `role_${id}`,
    // ...
  }
  
  // 🔍 DEBUG — log transformed output
  if (id === 999) console.log('transformed:', data)
  
  return { id, data }
}
```

**Pattern ที่ใช้บ่อย**: filter ตาม id ที่สงสัย ไม่ต้อง log ทั้ง 1000 rows

---

## Level 4: Node Inspector — Step debugger

เมื่อ log ไม่พอแล้ว — เปิด debugger ของจริง

### กับ VS Code

1. สร้าง `.vscode/launch.json`:
```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "type": "node",
      "request": "launch",
      "name": "Debug migrate",
      "runtimeExecutable": "npx",
      "runtimeArgs": ["tsx", "data_migration/migrate.ts", "sys_user"],
      "console": "integratedTerminal",
      "skipFiles": ["<node_internals>/**"]
    }
  ]
}
```

2. ใส่ breakpoint ใน `transform` หรือ `processRows`
3. กด F5 → debugger หยุดตรง breakpoint → hover ดูค่าตัวแปรได้

### CLI อย่างเดียว

```bash
node --inspect-brk -r tsx/cjs data_migration/migrate.ts sys_user
```

แล้วเปิด Chrome → `chrome://inspect` → ใช้ DevTools เป็น debugger

---

## 🐛 Debug Cookbook — ปัญหาที่จะเจอบ่อย (เผื่อ 100 ตาราง)

### Bug A: "Cannot read property X of null" ใน transform

**ที่มา**: legacy column ที่คาดว่าเป็น string แต่จริงเป็น `null`

**Debug**:
```ts
transform: (r) => {
  console.log('row keys:', Object.keys(r))
  console.log('row values:', r)
  // ...
}
```

**Fix**: ใช้ `??` หรือ `||` กัน:
```ts
name: (r.col_name as string) ?? 'default'
```

### Bug B: Unique constraint violation

ดูใน `report.errors`:
```json
{ "id": 12, "message": "Unique constraint failed on the fields: (`email`)" }
```

**Fix pattern**: เช่นที่ทำใน `sys_user.ts`:
```ts
const email = rawEmail && rawEmail !== '' ? rawEmail : null
//                                            ^^ null แทน '' ป้องกัน unique
```

### Bug C: Foreign key violation

```json
{ "id": 99, "message": "Foreign key constraint failed on field: role_id" }
```

**ที่มา**: insert row ที่อ้าง parent ที่ไม่มี
**Fix**: ใช้ skip pattern ใน sys_role_assignment เป็นตัวอย่าง — return `{ skip: 'role_not_found' }`

### Bug D: Date parse error

```json
{ "message": "Invalid `prisma.X.upsert()` invocation: Invalid value provided" }
```

**ที่มา**: `'0000-00-00 00:00:00'` หลุดเข้าไป — `parseDate` คลุมไม่ถึง

**Debug**:
```ts
console.log('raw date:', r.some_date, 'parsed:', parseDate(r.some_date))
```

**Fix**: เพิ่ม fallback ที่ `parseDate(value, new Date())`

### Bug E: Topological sort circular

```
Error: circular dependency: sys_a -> sys_b -> sys_c -> sys_a
```

**ที่มา**: ประกาศ `dependencies` แบบวนกัน
**Fix**: ดู path ที่ error ชี้ → ตัดอันใดอันหนึ่งออก หรือแยกเป็น 2-phase migration

---

## 🛠️ Debug Tools ที่อยากให้ติดตั้งเพิ่ม

### 1. เพิ่ม `--verbose` flag — log ทุก row

```ts
// runner.ts
if (ctx.verbose) {
  console.log(chalk.gray(`  ${table.name} id=${out.id}:`), out.data)
}
```

```bash
npx tsx data_migration/migrate.ts sys_role --verbose
```

### 2. เพิ่ม `--limit N` flag — รันแค่ N row แรก

```ts
const limitedRows = ctx.limit ? rows.slice(0, ctx.limit) : rows
```

```bash
npx tsx data_migration/migrate.ts sys_user --limit 5 --verbose
```

ใช้ debug การ migrate ตารางขนาดล้านแถวที่กว่าจะเจอ error ก็รอนาน

### 3. Save transformed data ก่อน insert

```ts
// runner.ts ใน dry-run mode — เก็บ data ลง result
if (ctx.dryRun) {
  result.samples = result.samples ?? []
  if (result.samples.length < 5) result.samples.push(out.data)
}
```

dry-run แล้วเปิด JSON → เห็น sample 5 rows แรกของแต่ละตาราง → debug schema mismatch ได้เร็ว

---

## 🎯 Debug Workflow ที่ผมแนะนำ

```
1. ตารางใหม่ → npx tsx migrate.ts <table> --dry-run --report
2. เปิด report.json — เช็ค skipReasons + errors
3. ถ้ามี error → npx tsx migrate.ts <table> --dry-run --verbose --limit 10
4. แก้ transform → ลูปข้อ 1-3 จนสะอาด
5. รันจริง: npx tsx migrate.ts <table>
6. รวมหลายตาราง: npx tsx migrate.ts --dry-run --report
7. รันจริงทั้งหมด: npx tsx migrate.ts --report
```

---

## Next step

อยากให้ผมเพิ่ม **`--verbose` + `--limit` flags** เลยไหมครับ? ใช้ debug ตอน scale ไป 100 ตารางได้คุ้มมาก — เขียนแค่ ~15 บรรทัด

หรือถ้ามี table ใหม่ที่อยาก convert อยากให้ลองด้วยกัน ก็แปะ schema/data มาได้