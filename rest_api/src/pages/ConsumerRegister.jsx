import '../page_css/Register.css'
import '../page_css/Basic.css'
import {consumerRegister} from "../methods/ConsumerRegisterMethod";


export const ConsumerRegister = () => {
    return (
        <div className="style-container">
            <div className="consumer-register-container">
                <h1>Зарегистрироваться</h1>
                <div className="consumer-register-form">
                    <form onSubmit={consumerRegister}>
                        <div className="form-elements">
                            <label>Номер телефона</label><br/>
                            <input name="phone" type="text" placeholder="Введите номер телефона"/>
                            <div className="error phone-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>ФИО</label><br/>
                            <input name="name" type="text" placeholder="Введите ФИО"/>
                            <div className="error name-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>Пароль</label><br/>
                            <input name="password" type="password" placeholder="Введите пароль"/>
                            <div className="error password-error"></div>
                        </div>
                        <button className="submit-button" type="submit">Войти</button>
                    </form>
                    <div className="consumer-register">
                        <div className="driver-authorize">
                            <a href='/driver_authorize'>Войти как водитель</a>
                        </div>
                        <div className="register">
                        <a href='/register'>Зарегистрироваться</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )

}