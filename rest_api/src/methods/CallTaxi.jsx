
export function callTaxi(){
    const priceElement = document.querySelector('.call-car-button')
    const sourceAddress = document.querySelector('.source-address').value
    const finalAddress = document.querySelector('.final-address').value
    const city = document.querySelector('.city').value
    const paymentMethodElement = document.querySelector('.payment-select').value
    let paymentMethod = ""
    if(paymentMethodElement === 'Наличные'){
        paymentMethod = 'cash'
    }else{
        paymentMethod = 'cart'
    }
    const price = priceElement.id
    setOrder(price,sourceAddress,finalAddress,city,paymentMethod).then(data => {
        if(data !== null){
            console.log(data);
            const waitTime = Math.round(data[0].distance * 1.3)
            const orderData = document.querySelector('.consumer-order-data')
            orderData.innerHTML = `
                <p>Расстояние до водителя: ${data[0].distance}км</p>
                <p>Приедет: ${data[0].message.name}</p>
                <p>Номер водителя: ${data[0].message.phone}</p>
                <p>Примерное время ожидания: ${waitTime}мин</p>
            `
        }else{
            const error = document.querySelector('.error')
            error.textContent = 'Сервис временно не доступен'
        }
    })
}
async function setOrder(price,sourceAddress,finalAddress,city,paymentMethod){
    const validateSourceAddress = sourceAddress.replace('дом', '')
    const validateFinalAddress = finalAddress.replace('дом', '')
    const data = {
        price:price,
        source_address:validateSourceAddress,
        final_address:validateFinalAddress,
        city:city,
        payment_method:paymentMethod,
    }
    const formData = new FormData()
    for (const key in data) {
        formData.append(key, data[key]);
    }
    const url = 'http://127.0.0.1/api/backend/orders/create.php'
    try{
        const response = await fetch(url,{
            method:'POST',
            credentials:'include',
            body:formData
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при создании заказа', error)
        return null
    }


}