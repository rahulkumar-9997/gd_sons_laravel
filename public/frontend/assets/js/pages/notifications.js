$(document).ready(function () {
    let notificationQueue = [];
    let notificationInterval = null;

    function fetchNotifications() {
        $.ajax({
            url: '/user-notifications',
            method: 'GET',
            dataType: 'json',
            success: function(notification) {
                if (notification && !notificationQueue.some(n => n.id === notification.id)) {
                    notificationQueue.push(notification);
                    if (!notificationInterval) {
                        showNextNotification();
                        notificationInterval = setInterval(showNextNotification, 10000);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    function showNextNotification() {
        if (notificationQueue.length === 0) {
            clearInterval(notificationInterval);
            notificationInterval = null;
            return;
        }

        let notification = notificationQueue.shift();
        if (!notification) return; // If no valid notification, exit

        let notifyElement = showNotificationUser("create", notification.title, notification.message, notification.id);

        setTimeout(() => {
            markNotificationAsRead(notification.id);
            $(notifyElement).fadeOut(500, function () {
                $(this).remove();
            });
        }, 60000); /* Hide after 1 minute */
    }

    function showNotificationUser(type, title, message) {
        if (!title || !message) return;
        
        let notifyElement = $.notify({
            icon: type === "success" ? "fa fa-check" : "fa fa-exclamation",
            title: title,
            message: message,
        }, {
            element: "body",
            position: null,
            type: type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right",
            },
            offset: 20,
            spacing: 5,
            z_index: 1031,
            delay: 60000, 
            animate: {
                enter: "animated fadeInDown",
                exit: "animated fadeOutUp",
            },
            template: `
                <div data-notify="container" class="alert bg-{0} toast-notification" role="alert"
                     style="max-width: 350px; min-width: 250px; word-wrap: break-word; display: flex; align-items: center; justify-content: space-between; padding: 10px;">
                    <span style="color: white; flex-grow: 1;" data-notify="message">{2}</span>
                    <button type="button" class="btn-close" data-notify="dismiss" style="margin-left: 10px;"></button>
                </div>
            `,
        });
    
        return notifyElement;
    }
    

    /*function showNotificationUser(type, title, message, id) {
        if (!title || !message) return; 

        let notifyElement = $.notify({
            icon: type === "success" ? "fa fa-check" : "fa fa-exclamation",
            title: title,
            message: message,
        }, {
            element: "body",
            type: type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "bottom",
                align: "left",
            },
            offset: 40,
            spacing: 10,
            z_index: 1031,
            delay: 60000,
            animate: {
                enter: "animated fadeInDown",
                exit: "animated fadeOutUp",
            },
            template: `
                <div data-notify="container" class="col-xxl-2 alert bg-{0} toast-notification" role="alert">
                    <button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>
                    <span style="color: white;" data-notify="message">{2}</span>
                </div>
            `,
        });

        return notifyElement;
    }*/

    function markNotificationAsRead(id) {
        if (!id) return;
    
        $.ajax({
            url: `/notifications/${id}/read`,
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({ id: id }),
            success: function() {
                console.log(`Notification ${id} marked as read.`);
            },
            error: function(xhr, status, error) {
                console.error('Error marking notification as read:', error);
            }
        });
    }
    

    function checkForNotifications() {
        fetchNotifications();

        if (notificationQueue.length === 0) {
            clearInterval(notificationInterval);
            notificationInterval = null;
        }
    }

    setInterval(checkForNotifications, 10000);
});
