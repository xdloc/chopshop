# ChopShop API

## What's done:
* Plain PHP project, PHP 8.2, MariaDB
* Some composer packages, composer autoload
* Models, Controllers, but Views was moved to separate frontend project based on Vue.js, and this app turned to API
* https://chopshop-app.netlify.app
* CI/CD (autodeploy master branches, Github Actions+VPS for backend, Netlify for frontend)
* Api methods: list, add, remove (almost)
* Sentry
* CORS


## What's left undone:
* Api methods: edit, mark
* Users and user access
* Main list model
* .env
* DB Migrations
* Tests
* URL Rewrites
* Docker/K8S
* Cache
* CSS Preprocessing
* More complex structured API (REST, JSON-RPC) with auth

## API
### list/list
Show all items
### list/add
Add new item
### list/edit
Edit the item
### list/mark
Mark item as checked/unchecked
### list/remove
Delete the item