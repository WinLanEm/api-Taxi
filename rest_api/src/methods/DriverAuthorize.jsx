export async function checkRole(){
    await fetch('http://127.0.0.1/api/backend/drivers/role.php',{
        credentials: 'include',
        method: 'GET',
    }).then((response) => {
        return response.json()
    }).then((data) => {
        if(data.status === true){
            window.location.href = '/driver_authorize'
            alert('Авторизируйтесь')
        }
    })
}


export async function DriverAuthorizeMethod(event){
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    let phone = document.querySelector('.phone-error')
    let password = document.querySelector('.password-error')
    try {await fetch('http://127.0.0.1/api/backend/drivers/login.php',{
        method: 'POST',
        credentials: 'include',
        body: formData
    }).then((response) => {
        return response.json();
    })
        .then((data) => {
            if(data.message === 'success'){
                window.location.href = '/driver_home'
            }
            if(data.message === 'Driver with this phone not found'){
                phone.textContent = 'Водитель с таким номером не найден';
                password.textContent = ''
            }
            if(data.message === 'invalid password'){
                password.textContent = 'Неверный пароль'
                phone.textContent = ''
            }
            console.log(data);
        });
    } catch (error){
        console.log(error)
    }
}