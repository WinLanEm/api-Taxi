import {checkRole} from "../methods/DriverAuthorize";
import {getDriverGEO} from "../methods/GetGEO";
import {StartWork,EndWork,activeOrder,cancelOrder} from "../methods/DriverHomeMethods";
import {useEffect,useState} from "react";


export function DriverHome(){
    const [counter, setCounter] = useState(0);
    checkRole()
    getDriverGEO()
    EndWork()
    useEffect(() => {
        const intervalId = setInterval(() => {
            console.log('Функция вызвана');
            setCounter(prevCounter => prevCounter + 1);
        }, 10000000);
        return () => clearInterval(intervalId);
    }, []);
    return(
        <div>
            <div>
                <div className='driver-location-div'>
                    <input className='driver-location'/>
                </div>
                <h1>Водительская панель</h1>
                <div className='order-form'>
                    <div>
                        <div className='order-driver-data'>
                            <div className='driver-status'>

                            </div>
                        </div>
                        <div className='driver-buttons'>
                            <button className='work-start' onClick={StartWork}>Начать работу</button>
                            <button className='work-end' onClick={EndWork}>Закончить работу</button>
                        </div>
                        <div className='order-container'>
                            <p className='order-source-address'></p>
                            <p className='order-final-address'></p>
                            <p className='order-payment-method'></p>
                            <p className='order-trip-price'></p>
                            <p className='order-waiting-price'></p>
                            <button onClick={cancelOrder}>Отменить заказ</button>
                        </div>
                        <button onClick={activeOrder}>Посмотреть заказ</button>
                    </div>
                </div>
            </div>
        </div>
    )
}