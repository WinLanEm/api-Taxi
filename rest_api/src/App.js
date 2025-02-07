import logo from './logo.svg';
import './App.css';


import { HomePage } from './pages/HomePage';
import { ProfilePage } from './pages/ProfilePage';
import {ConsumerRegister} from "./pages/ConsumerRegister";
import {ConsumerAuthorize} from "./pages/ConsumerAuthorize";
import {DriverAuthorize} from './pages/DriverAuthorize';
import {DriverRegister} from './pages/DriverRegister';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import {DriverHome} from "./pages/DriverHome";
import {ConsumerOrder} from "./pages/ConsumerOrder";
import {CallTaxi} from './pages/CallTaxi'


function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/authorize" element={<ConsumerAuthorize />} />
        <Route path="/home" element={<HomePage/>} />
          <Route path="/register" element={<ConsumerRegister/>}/>
          <Route path="/driver_authorize" element={<DriverAuthorize/>}/>
          <Route path="/driver_register" element={<DriverRegister/>}/>
          <Route path='/driver_home' element={<DriverHome/>}/>
          <Route path="/consumer_order" element={<ConsumerOrder/>}/>
          <Route path="/call_taxi" element={<CallTaxi/>}/>
      </Routes>
    </BrowserRouter>
  )
}

export default App;
