
export async function checkRole(){
    await fetch('http://127.0.0.1/api/backend/consumers/role.php',{
        credentials: 'include',
        method: 'GET',
    }).then((response) => {
        return response.json()
    }).then((data) => {
        if(data.status === true){
            window.location.href = '/authorize'
            alert("Авторизируйтесь")
        }
    })
}

export async function consumerAuthorize(event){
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    let phone = document.querySelector('.phone-error')
    let password = document.querySelector('.password-error')
    try {await fetch('http://127.0.0.1/api/backend/consumers/login.php',{
        method: 'POST',
        credentials: 'include',
        body: formData
    }).then((response) => {
        return response.json();
    })
        .then((data) => {
            if(data.message === 'success'){
                window.location.href = '/home'
            }
            if(data.message === 'Consumer with this phone not found'){
                phone.textContent = 'Пользователь с таким номером не найден';
                password.textContent = ''
            }
            if(data.message === 'invalid password'){
                password.textContent = 'Неверный пароль'
                phone.textContent = ''
            }
            console.log(data)
        });
    } catch (error){
        console.log(error)
    }
}

