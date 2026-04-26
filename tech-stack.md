# Software Architecture
1. Monolithic Architecture (sigle unit)
2. Microservices Architecture (scalability)
3. Layered Architecture

## Middleware
Client -> Request -> `Middleware` -> Response -> Route/Endpoint

### Production 1
> Note: Monorepo separate `backend/` and `frontend/`
> - `frontend/`
> 	- `package.json` (replace `"dev": "vite"`)
> 	- `tsconfig.json`
> 	- `vit.config.json`
> 	- `index.html`
> 	- `metadata.json`?
> 	- `src/`
> - `backend/`
> 	- `package.json`
> 	- `tsconfig.json`
> 	- `server.ts` (starter: this file look at `scripts` line in `package.json`)
> 	- `server/`

1. Environment configuration both `frontend`, `backend` (`.env.example` interface)
	- `.env.dev`
	- `.env.production`

2.