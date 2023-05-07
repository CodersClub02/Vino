import axios from "axios";

axios.defaults.withCredentials = true;
// axios.defaults.timeout = 2000;
axios.defaults.baseURL = "http://" + window.location.hostname + ":8000";
