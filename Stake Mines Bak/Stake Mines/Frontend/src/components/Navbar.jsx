import React from 'react'
import stakeLogo from '../assets/stake-logo.svg'
import { FaUser} from "react-icons/fa";
import { GiWallet } from "react-icons/gi";

const Navbar = () => {
  return (
    <nav className='flex navbar justify-around w-full'>
      <img src={stakeLogo} alt="" className='w-16 cursor-pointer'/>
      <div className="wallet py-2 px-3 flex">
        <div className="amount-box flex px-4 py-3 rounded-l-md cursor-pointer"><span className='text-sm font-bold self-center'>₹0.00</span> <img src="../src/assets/rupee-logo.png" alt="" className='w-4 h-4 self-center m-1'/></div>
        <div className="wallet-btn flex justify-center rounded-r-md cursor-pointer"><span className='self-center px-4 font-bold text-white text-xs wallet-text'>Wallet</span><GiWallet className="text-white self-center wallet-icon m-4"/></div>
      </div>
      <div className="user-part flex items-center justify-center cursor-pointer"><FaUser className='fill-white'/></div>
    </nav>
  )
}

export default Navbar
