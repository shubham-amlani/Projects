import React from 'react'
import {playSound} from './SoundPlayer'

const Sidebar = () => {
    const betClick = () =>{
        playSound('/sounds/click.mp3');
    }
  return (
    <div className='sidebar md:rounded-l-md flex flex-col lg:w-[300px] lg:h-[632px] md:h-[472px] sm:w-[456px] w-[310px]'>
        <div className="sidebar-btns sm:w-[290px] sm:h-[60px] rounded-full flex justify-center items-center mx-2 my-3 h-[40px]">
            <div className="btn-box rounded-full p-1 flex w-[99%] h-[95%] gap-2">
                <button className='rounded-full px-5 w-[48%] font-bold text-white sidebar-active text-sm'>Manual</button>
                <button className='rounded-full px-5 w-[48%] font-bold text-white text-sm'>Auto</button>
            </div>
        </div>
    <div className="bet-form">
        <div className='flex justify-between mx-4'>
            <span className='text-sm text-gray-400 font-bold'>Bet Amount</span>
            <span className='text-sm text-gray-400 font-bold'>₹0.00</span>
        </div>
        <div className="input-div mx-4 my-1 flex">
        <input type="number" name="bet-amount" id="" className='rounded-sm m-0.5 h-9 text-white font-bold text-sm p-2 w-[70%]'/>
        <span className="half font-bold text-sm text-white p-2 cursor-pointer"> 1/2</span>
        <span className="double font-bold text-sm text-white p-2 cursor-pointer">2x</span>
        </div>
        
        <div className='flex justify-between mx-4 my-1'>
            <span className='text-sm text-gray-400 font-bold'>Mines</span>
        </div>
        <div className="mx-4 w-[90%]">
        <input type="number" name="bet-amount" id="" className='rounded-sm h-9 text-white font-bold text-sm p-2 w-full'/>
        </div>
        <button className="bet-btn font-bold text-sm w-[90%] mx-4 my-3 h-12 rounded-md" onClick={betClick}>Bet</button>
    </div>
    </div>
  )
}

export default Sidebar
