# Scheduly
![build](https://github.com/Flayshon/scheduly/workflows/build/badge.svg)

A Laravel/Vue application for scheduling events and managing tasks related to them.

## Development status

### Back-end

The core **Event** concept is mostly implemented and tested (TDD), only missing [recurrence rules](https://github.com/jakubroztocil/rrule). Working on **User** management and **Organization** concept next.

Response data is being passed to the front-end components using [Inertia.js](https://inertiajs.com/)

### Front-end

Successfully migrated the front-end prototype to use [Vuetify 2 Calendar component](https://vuetifyjs.com/en/components/calendars/). Currently working on expanding its functionalities to include a dynamic time slot resize option using v-calendar event listeners ([Lodash](https://lodash.com/) might come in handy to optimize that behavior).