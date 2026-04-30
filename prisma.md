# Prisma ORM (Object-Relational Mapping)

### Prisma CLI
```
npm install prisma --save-dev
```

### Init
```
npx prisma init
```

### Edit .env
`DATABASE_URL`

## Rename table
use `@@map("<name>")`

```
npx prisma migrate dev --name rename_table_all

npx prisma generate

# seed
npx prisma db seed
```