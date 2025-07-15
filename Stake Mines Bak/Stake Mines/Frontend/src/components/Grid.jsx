import React from "react";
import Tile from "./Tile";

const Grid = () => {
  return (
    <>
      <div className="grid-main flex justify-center md:rounded-r-md lg:w-[790px] md:w-[610px] sm:w-[460px] w-[310px] rounded-t-sm">
          <div className="grid-inner grid grid-cols-5 grid-rows-5 gap-2 md:py-5 sm:py-3 lg:w-[590px] md:w-[440px] sm:w-[440px] w-[300px] py-2">
          {Array.from({ length: 25 }, (_, index) => (
          <Tile key={index} coords={index}/>
          ))}
          </div>
      </div>
    </>
  );
};

export default Grid;
