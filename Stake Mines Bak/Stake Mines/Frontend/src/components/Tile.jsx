import React, {useState}from 'react'
import mineLogo from '../assets/mine.svg'
import {playSound} from './SoundPlayer'

const Tile = ({coords}) => {
  const [startGame, setstartGame] = useState(true)
  const [revealed, setRevealed] = useState(false);
  const [isFetching, setIsFetching] = useState(false)
  const revealTile = (e)=>{
    if(startGame){
      const tileCoords = e.target.getAttribute('coords');
      if (!revealed) {
        setRevealed(true);
        // playSound("/sounds/gem.mp3")
        playSound("/sounds/mine.mp3")
      }
    }
  }

  return (
    <>
    <button className={`tile tile-hover lg:w-[7rem] lg:h-[7rem] lg:rounded-lg md:w-[5rem] md:h-[5rem] md:rounded-md sm:w-[5rem] sm:h-[5rem] sm:rounded-md w-[3.2rem] h-[3.2rem] rounded-md ${revealed ? 'mine' : 'tile-hover'} ${isFetching ? 'fetching' : ''}`} onClick={revealTile} coords={coords} >{revealed && <>
          <img alt="mine effect" className="effect translate-x[-2px] sm:translate-y[-25px] translate-y[-12px]" src="/blast.gif" />
          <img src={mineLogo} alt="" className='mine mx-auto'/>
        </>}
    </button>
    </>
  )
}

export default Tile
