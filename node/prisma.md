# Prisma ORM (Object-Relational Mapping)

### Prisma CLI
`npm install prisma --save-dev` install \
`npx prisma init` init

`npx prisma validate` validate `schema.prisma` \
`npx prisma db pull` check connect db

### Create `migrations/`
`npx prisma migrate dev --name init`

### Create prisma client `generated/prisma`
`npx prisma generate`
- *`--schema=<path_schema>` schema path*

### Edit table
1. edit `schema.prisma`
2. `npx prisma migrate dev --name add_<table_name>`

### Reset database
remove `/prisma/migrations` and then:
```
npx prisma migrate reset
npx prisma migrate dev --name init
npx prisma db seed
```