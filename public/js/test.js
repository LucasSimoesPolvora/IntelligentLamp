let script = document.createElement('script');
script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js';
document.getElementsByTagName('head')[0].appendChild(script);


document.addEventListener('DOMContentLoaded', function () {
    
    const notificationBox = document.getElementById('notificationBox');
    const audio = document.getElementById('audio');

    let oldNotifications = [];

    document.getElementById('btn').addEventListener('click', function () {
        insertNewNotification();
    });

    setInterval(() => {
        $.ajax({
            url: '/test-get',
            type: 'GET',
            success: function (response) {
                console.log(response.message);
    
                if (response.length === 0) {
                    return;
                }

                if (oldNotifications.length === response.message.length) {
                    return;
                }
                else {
                    audio.volume = 1;
                    audio.play();
                }
                
                notificationBox.innerHTML = '';
                oldNotifications = response.message;

                for (let i = response.message.length - 1; i >= 0; i--) {
                    let notification = response.message[i];

                    let notificationDiv = document.createElement('div');
                    notificationDiv.classList.add('notification');

                    let title = document.createElement('h2');
                    title.textContent = notification.title;

                    let content = document.createElement('p');
                    content.textContent = notification.content;

                    notificationDiv.appendChild(title);
                    notificationDiv.appendChild(content);

                    notificationBox.appendChild(notificationDiv);

                }
            }
        });

    }, 5000);
});

const insertNewNotification = () => {
    $.ajax({
        url: '/insert/notification',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'title': 'Hello',
            'message': 'World',
            'fkLampadaire': 1
        },
        success: function (data) {
            console.log(data);
        }
    })
}