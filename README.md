# Scheduly
![build](https://github.com/Flayshon/scheduly/workflows/build/badge.svg)

A Laravel/Vue application for scheduling events and managing tasks related to them.

## Development

### Back-end

The core **Event** concept is mostly implemented and tested (TDD). Working on **User** management and **Organization** concept next.

The response data is being passed to the front-end components using [Inertia.js](https://inertiajs.com/)

### Front-end

The current prototype uses the base implementation of [dayspan-vuetify](https://github.com/ClickerMonkey/dayspan-vuetify), but I'm working on refactoring it to a custom implementation of the [Vuetify Calendar component](https://vuetifyjs.com/en/components/calendars/) since dayspan-vuetify probably won't be updated anymore.
