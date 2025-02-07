export const FoundDriver = () => {
    userWaitData().then(data => {
        const sourceAddress = document.querySelector('.source-address')
        const finalAddress = document.querySelector('.final-address')
        const paymentMethod = document.querySelector('.payment-method')
        const status = document.querySelector('.status')
        const tripPrice = document.querySelector('.trip-price')
        const waitingPrice = document.querySelector('.waiting-price')
        sourceAddress.textContent = data.source_address
        finalAddress.textContent = data.final_address

        tripPrice.textContent = data.trip_price
        waitingPrice.textContent = data.waiting_price
        if(data.status === 'inactive'){
            status.textContent = 'Ожидание водителя'
        }else{
            status.textContent = 'Водитель принял заказ'
        }
        if(data.payment_method === 'cash'){
            paymentMethod.textContent = "Наличные"
        }else{
            paymentMethod.textContent = 'Карта'
        }
    })
}

async function userWaitData(){
    const url = `http://127.0.0.1/api/backend/orders/consumer.php`
    try{
        const response = await fetch(url,{
            credentials:'include',
            method:'GET',
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при получении данных заказа', error)
        return null
    }
}
export function removeOrder(){
    removeOrderMethod().then(data => {
        window.location.href = '/home'
        alert("Заказ отменен")
    })
}
async function removeOrderMethod(){
    const url = `http://127.0.0.1/api/backend/orders/delete.php`
    try{
        const response = await fetch(url,{
            credentials:'include',
            method:'DELETE',
        })
        if(!response.ok){
            throw new Error(`Ошибка HTTP: ${response.status}`)
        }
        const result = await response.json()
        return result
    }catch (error){
        console.error('Ошибка при удалении заказа', error)
        return null
    }
}