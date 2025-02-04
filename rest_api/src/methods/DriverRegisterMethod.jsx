export async function driverRegisterMethod(event){
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    let phone = document.querySelector('.phone-error')
    let password = document.querySelector('.password-error')
    const brand = document.querySelector('.brand-error')
    try {await fetch('http://127.0.0.1/api/backend/drivers/create.php',{
        method: 'POST',
        credentials: 'include',
        body: formData
    }).then((response) => {
        return response.json();
    })
        .then((data) => {
            if(data.message === 'Enter unique number'){
                phone.textContent = "Введите уникальный номер"
            }
            if(data.message === 'the phone number must start with +7, 8 or 7'){
                phone.textContent = "Телефон должен начинаться с +7, 8, 7"
            }
            if(data.message === 'invalid phone'){
                phone.textContent = "Некорректный номер"
            }
            if(data.message === 'The password is too short'){
                password.textContent = "Пароль должен быть больше 8 символов"
            }
            if(data.message === 'The password must contain at least one uppercase letter'){
                password.textContent = "Пароль должен содержать заглавные буквы"
            }
            if(data.message !== "Enter unique number" && data.message !== "the phone number must start with +7, 8 or 7" && data.message !== "invalid phone"){
                phone.textContent = ''
            }
            if(data.message !== "The password is too short" && data.message !== 'The password must contain at least one uppercase letter'){
                password.textContent = ''
            }
            if(data.message === "This car not found"){
                brand.textContent = "Машина не найдена"
            }
            if(data.message !== "This car not found"){
                brand.textContent = ""
            }
            if(data.status === true){
                window.location.href = "/driver_authorize"
            }
            console.log(data);
        });
    } catch (error){
        console.log(error)
    }
}