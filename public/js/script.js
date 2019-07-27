function submitSubscription(e, type) {
    e.preventDefault();
    const target = e.target;
    const { method, action } = target;

    const name = e.target.name.value;
    const email = e.target.email.value;

    const xhr = new XMLHttpRequest();

    const body = new URLSearchParams({
        name,
        email,
        type,
    }).toString();

    xhr.open(method, action, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    target.querySelector('button.submit').innerHTML = "Отправляем...";

    xhr.onload = function() {
        if (xhr.status === 200) {
            target.parentElement.querySelector('.success-message').classList.remove('hidden');
            target.remove();
            return;
        } else if (xhr.status === 422) {
            target.parentElement.querySelector('.error-message').classList.remove('hidden');
        } else {
            alert("Sorry, service is not available");
        }

        target.querySelector('button.submit').innerHTML = "Подписаться";
    };

    xhr.send(body);
}