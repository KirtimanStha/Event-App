import { createRouter, createWebHistory } from 'vue-router'
 
import Welcome from '../components/Welcome.vue';
import Event from '../components/Event.vue';
import EventList from '../components/event/List.vue';
import EventCreate from '../components/event/Create.vue';
import EventUpdate from '../components/event/Update.vue';
const routes = [
    {
        name: 'home',
        path: '/',
        component: Welcome
    },
    {
        name: 'eventList',
        path: '/event',
        component: EventList
    },
    {
        name: 'eventCreate',
        path: '/event/add',
        component: EventCreate
    },
    {
        name: 'eventUpdate',
        path: '/event/:id/edit',
        component: EventUpdate
    },

    {
        name: 'event',
        path: '/event/:id',
        component: Event
    }
];
 
export default createRouter({
    history: createWebHistory(),
    routes
})