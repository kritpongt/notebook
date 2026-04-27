# Troubleshooting Docker 404 Error

หน้าเว็บขึ้น 404 Not Found บน Docker มักเกิดจาก 3 ส่วนหลัก: **Routing (Proxy)**, **Container Status**, หรือ **Volume Mapping**

### 1. เช็คสถานะ Container
ตรวจสอบว่า Container ที่รัน Web Server หรือ Backend ยังทำงานอยู่หรือไม่
```powershell
docker ps
```
- ถ้าไม่เห็น Container ในลิสต์ ให้เช็คตัวที่ตายไปแล้ว: `docker ps -a`
- ถ้าสถานะเป็น `Exited` ให้เช็ค Log: `docker logs <container_name>`

### 2. เช็ค Reverse Proxy (Nginx / Traefik)
ถ้าใช้ Nginx เป็น Proxy ตัว Nginx อาจหา Service ข้างหลังไม่เจอ
- **Check Config:** ตรวจสอบไฟล์ `.conf` ว่า `proxy_pass` ยิงไปถูกชื่อ Service หรือ Port หรือไม่
- **Docker Network:** Proxy กับ Web App ต้องอยู่บน Network เดียวกัน
```powershell
docker network ls
docker network inspect <network_name>
```

### 3. เช็ค Volume Mapping (Path mismatch)
404 มักเกิดจากไฟล์ไม่อยู่ในจุดที่ Web Server เรียก (เช่น `/var/www/html`)
- ตรวจสอบ `docker-compose.yml` ตรงส่วน `volumes:`
```yaml
volumes:
  - ./src:/var/www/html  # ฝั่งซ้าย (เครื่องเรา) ต้องมีไฟล์จริง และฝั่งขวาต้องถูก path
```
- ลองเข้าไปเช็คไฟล์ข้างใน Container:
```powershell
docker exec -it <container_name> ls -la /var/www/html
```

### 4. เช็ค Application Routing
บางครั้ง Docker ทำงานปกติ แต่ Route ใน Code ผิด (เช่น Laravel, Node.js, React)
- เช็ค Logs ของ App โดยตรง:
```powershell
docker logs -f <app_container_name>
```
- ดูว่า Request เข้ามาถึง App หรือยัง (ถ้าถึงแล้วแสดงว่าเป็นที่ Code/Framework)

### 5. วิธีแก้เบื้องต้น (Quick Fix)
ลองล้างแล้วรันใหม่เผื่อมี Cache หรือ Config ค้าง
```powershell
docker-compose down
docker-compose up -d --build
```

---
*Created on: 2026-04-27*
