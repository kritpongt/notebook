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

## Reset migrate (remove `/prisma/migrations`)
```
npx prisma migrate reset
npx prisma migrate dev --name init
npx prisma db seed
```