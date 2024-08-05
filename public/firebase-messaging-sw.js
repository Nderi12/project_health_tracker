importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: env('API_KEY'),
    authDomain: ENV('AUTH_DOMAIN'),
    projectId: env('PROJECT_ID'),
    storageBucket: env('STORAGE_BUCKET'),
    messagingSenderId: env('MESSAGING_SENDER_ID'),
    appId: env('APP_ID'),
    measurementId: env('MEASUREMENT_ID')
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});