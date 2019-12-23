# Phone Debugger

## Requirements

**Backend and Environment**

[Docker](https://www.docker.com/)

[Composer](https://getcomposer.org/)

[Nexmo Account with a Voice Application](https://dashboard.nexmo.com/voice/your-applications) (this will include an API key and secret)

[Ngrok](https://ngrok.com/)

**Frontend**

[Yarn](https://yarnpkg.com/lang/en/) or [NPM](https://www.npmjs.com/)

## Setup

Step 1: `composer install`

Step 2: `yarn/npm install`

Step 3: Create a `.env.local` that contains the Nexmo details (overriding the blank details in the default `.env`) 

Step 3: `docker-compose up -d` This sets up PHP, MYSQL and NGINX and REDIS. 

This step will also run all migrations for the DB meaning the site is ready to go out the box.

Step 4: setup your Nexmo Call application found [here](https://dashboard.nexmo.com/voice/your-applications) to use `/api/nexmo-event`

Note: in development I recommend using [ngrok](https://ngrok.com/) when listening for the nexmo events locally. 

## Misc

Web address: `localhost:8080`

To run the queue system after a call run: `bin/console dtc:queue:run`

This repo was used to create an article for Nexmo: https://www.nexmo.com/blog/2019/11/14/creating-a-phone-status-checker-with-nexmo-and-php-dr
