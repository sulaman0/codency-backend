// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyCCOy_SWpB3H0XYFbt35ACFxoDSLawffoc",
    authDomain: "codency-a6782.firebaseapp.com",
    projectId: "codency-a6782",
    storageBucket: "codency-a6782.appspot.com",
    messagingSenderId: "884169670185",
    appId: "1:884169670185:web:5e50eeddeecd99dae36638",
    measurementId: "G-LCCC0GVH6G"
});

self.addEventListener('notificationclick', function (event) {
    if (typeof event.notification.data.FCM_MSG.data.url !== 'undefined') {
        clients.openWindow(event.notification.data.FCM_MSG.data.url);
    }
    alert('test');
})

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    options.silent = false;
    options.renotify = true;
    return self.registration.showNotification(
        title,
        options
    );
});


