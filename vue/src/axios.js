import axios from "axios";

axios.defaults.withCredentials = true;
// axios.defaults.timeout = 2000;
//source:https://stackoverflow.com/questions/64910411/heroku-django-backend-is-not-working-getting-error-get-http-localhost8000-a
// if (window.location.origin === "http://localhost:3000") {
//   axios.defaults.baseURL = "http://localhost:8000";
// } else if (window.location.origin === "http://spa.vino.local") {
//   axios.defaults.baseURL = "http://api.vino.local";
// }else {
//   axios.defaults.baseURL = 'https://apivino.saddektouati.site';
// }

axios.defaults.baseURL = "http://" + window.location.hostname + ":8000";
