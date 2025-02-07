export async function StartWork(){
    const status = {
        status:'active',
    }
    const url = 'http://127.0.0.1/api/backend/drivers/work_status_change.php'
    const response = await fetch(url,{
        credentials:'include',
        method:'PATCH',
        body:JSON.stringify(status)
    })
    const result = await response.json()
    const driverStatus = document.querySelector('.driver-status')
    if(result.message === 'active'){
        driverStatus.textContent = 'Активен'
    }
    return result
}
export async function EndWork(){
    const status = {
        status:'inactive',
    }
    const url = 'http://127.0.0.1/api/backend/drivers/work_status_change.php'
    const response = await fetch(url,{
        credentials:'include',
        method:'PATCH',
        body:JSON.stringify(status)
    })
    const result = await response.json()
    const driverStatus = document.querySelector('.driver-status')
    if(result.message === 'inactive'){
        driverStatus.textContent = 'Не активен'
    }
    return result
}

export async function activeOrder() {
    const url = 'http://127.0.0.1/api/backend/drivers/get_order.php'
    const response = await fetch(url, {
        credentials: 'include',
        method: 'GET',
    })
    const result = await response.json()
    if(result === null){
        const orderContainer = document.querySelector('.order-container')
        orderContainer.style.display = 'block'
        const sourceAddress = document.querySelector('.order-source-address')
        sourceAddress.textContent = 'Нет заказов'
    }else{
        const sourceAddress = document.querySelector('.order-source-address')
        const finalAddress = document.querySelector('.order-final-address')
        const paymentMethod = document.querySelector('.order-payment-method')
        const tripPrice = document.querySelector('.order-trip-price')
        const waitingPrice = document.querySelector('.order-waiting-price')
        sourceAddress.textContent = `Откуда: ${result.source_address}`
        finalAddress.textContent = `Куда: ${result.final_address}`
        paymentMethod.textContent = `Оплата: ${result.payment_method}`
        tripPrice.textContent = `Цена поездки: ${result.trip_price}`
        waitingPrice.textContent = `Цена за ожидание: ${result.waiting_price}`
        const orderContainer = document.querySelector('.order-container')
        orderContainer.style.display = 'block'
        return result
    }
}
export async function cancelOrder(){
    const url = 'http://127.0.0.1/api/backend/drivers/cancel_order.php'
    const response = await fetch(url,{
        credentials:'include',
        method:'PATCH',
    })
    const result = await response.json()
    console.log(result)
    if(result.status === true){
        const orderContainer = document.querySelector('.order-container')
        orderContainer.style.display = 'none'
    }
    return result
}