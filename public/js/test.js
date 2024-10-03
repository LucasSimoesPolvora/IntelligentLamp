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

    setInterval(async () => {
        $.ajax({
            url: '/test-get',
            type: 'GET',
            success: function (response) {
                // console.log(response);
                
                if (response.length === 0) {
                    // console.log('test');
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

                    let date = document.createElement('p');
                    date.textContent = "Date : " + new Date(Date.parse(notification.created_at)).toLocaleString();

                    let content = document.createElement('p');
                    content.textContent = `Content : \n${notification.content}`;

                    let lampadaire = document.createElement('p');

                    $.ajax({
                        url: '/lampadaire/' + notification.fkLampadaire,
                        type: 'GET',
                        async: false,
                        success: function (response) {
                            // console.log(response);
                            lampadaire.textContent = `Address : ${response.lampadaire.address}`;
                            // lampadaire.textContent = response.lampadaire.name;
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    });

                    notificationDiv.appendChild(title);
                    notificationDiv.appendChild(date);
                    notificationDiv.appendChild(content);
                    notificationDiv.appendChild(lampadaire);

                    notificationBox.appendChild(notificationDiv);

                }
            },
            error: function (error) {
                console.log(error);
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