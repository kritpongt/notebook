# Prisma ORM (Object-Relational Mapping)

### Prisma CLI
`npm install prisma --save-dev` install

`npx prisma validate` validate `schema.prisma` \
`npx prisma db pull` check connect db

### Init
`npx prisma init`

### Create `migrations/`
`npx prisma migrate dev --name init`

### Create Prisma Client `generated/prisma`
`npx prisma generate`
- *`--schema=<path_schema>` schema path*

### Reset migrate (remove `/prisma/migrations`)
```
npx prisma migrate reset
npx prisma migrate dev --name init
npx prisma db seed
```