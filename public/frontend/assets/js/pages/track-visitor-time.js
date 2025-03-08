// let startTime = new Date().getTime();
// function sendTimeSpent() {
//     let endTime = new Date().getTime();
//     let timeSpent = Math.floor((endTime - startTime) / 1000);
//     let csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
//     fetch('/track-time', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': csrfToken
//         },
//         body: JSON.stringify({
//             time_spent: timeSpent,
//             page_name: window.location.pathname
//         })
//     });
// }
// document.addEventListener("visibilitychange", function () {
//     if (document.hidden) {
//         sendTimeSpent();
//     }
// });
// window.addEventListener("beforeunload", sendTimeSpent);
