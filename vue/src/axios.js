import axios from "axios";

axios.defaults.withCredentials = true;
// axios.defaults.timeout = 2000;
//source:https://stackoverflow.com/questions/64910411/heroku-django-backend-is-not-working-getting-error-get-http-localhost8000-a
// if (window.location.origin.includes(":3000")) {
// axios.defaults.baseURL = "http://" + window.location.hostname + ":8000";
// }
axios.defaults.baseURL = "http://" + window.location.hostname + ":8000";
// axios.defaults.baseURL = 'http://vino.local';
