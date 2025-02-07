import {FoundDriver,removeOrder} from "../methods/FoundDriver";

export const CallTaxi = () => {
    FoundDriver()
    return(
        <div className='order-form'>
            <h1 className='order-h1'>Панель ожидания</h1>
            <div className='found-driver'>Водитель ищется</div>
            <div className="order-data">
                <div className="order-data-item">
                    <p>Исходный адрес:</p>
                    <p className="source-address"></p>
                </div>
                <div className="order-data-item">
                    <p>Конечный адрес:</p>
                    <p className="final-address"></p>
                </div>
                <div className="order-data-item">
                    <p>Метод оплаты:</p>
                    <p className="payment-method"></p>
                </div>
                <div className="order-data-item">
                    <p>Статус заказа:</p>
                    <p className="status"></p>
                </div>
                <div className="order-data-item">
                    <p>Стоимость поездки:</p>
                    <p className="trip-price"></p>
                </div>
                <div className="order-data-item">
                    <p>Стоимость ожидания:</p>
                    <p className="waiting-price"></p>
                </div>
            </div>
            <div>
                <button className='order-submit-button' onClick={removeOrder}>Отменить заказ</button>
            </div>
        </div>
    )
}