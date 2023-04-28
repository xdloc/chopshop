# ChopShop API

What's done:
* Plain PHP project, PHP 8.2, MariaDB
* Some composer packages, composer autoload
* Models, Controllers, but Views was moved to separate frontend project based on Vue.js, and this app turned to API
* https://chopshop-app.netlify.app
* CI/CD (autodeploy master branches, Github Actions+VPS for backend, Netlify for frontend)
* Api methods: list, addItem, removeItem, editItem
* Sentry


What's left undone:
* Users and user access
* Main list model
* .env
* DB Migrations
* Tests
* URL Rewrites
* Docker/K8S
* Cache
* CSS Preprocessing