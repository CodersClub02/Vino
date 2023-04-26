import axios from "axios";

axios.defaults.withCredentials = true;

//source:https://stackoverflow.com/questions/64910411/heroku-django-backend-is-not-working-getting-error-get-http-localhost8000-a
if (window.location.origin === "http://localhost:3000") {
  axios.defaults.baseURL = "http://127.0.0.1:8000";
} else {
  axios.defaults.baseURL = window.location.origin + ':8000';
}
