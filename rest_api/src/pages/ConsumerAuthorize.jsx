import '../page_css/Authorize.css'
import '../page_css/Basic.css'
import {consumerAuthorize,checkRole} from "../methods/ConsumerAuthorizeMethod";


export const ConsumerAuthorize = () => {
    return (
        <div>
            <div className="consumer-authorize-container">
                <h1>Авторизация</h1>
                <div className="consumer-form">
                    <form onSubmit={consumerAuthorize}>
                        <div className="form-elements">
                            <label>Номер телефона</label><br/>
                            <input name="phone" type="text" placeholder="Введите номер телефона"/>
                            <div className="error phone-error"></div>
                        </div>
                        <div className="form-elements">
                            <label>Пароль</label><br/>
                            <input name="password" type="password" placeholder="Введите пароль"/>
                            <div className="error password-error"></div>
                        </div>
                        <button className="submit-button" type="submit">Войти</button>
                    </form>
                    <div className="register-driver">
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