import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBackspace, faArrowRight } from "@fortawesome/free-solid-svg-icons";
import "../styles/Keyboard.css";

const Keyboard = ({ onKeyPress, keyboardColors }) => {
  const rows = [
    ["Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P"],
    ["A", "S", "D", "F", "G", "H", "J", "K", "L"],
    ["Backspace", "Z", "X", "C", "V", "B", "N", "M", "Enter"],
  ];

  const handleButtonClick = (col) => {
    onKeyPress(col);
  };

  return (
    <div className="keyboard-container">
      {rows.map((row, rowIndex) => (
        <div key={rowIndex} className={`keyboard-row row-${rowIndex}`}>
          {row.map((col, colIndex) => (
            <button
              key={colIndex}
              className={`key-button ${keyboardColors[col] || ""}`}
              onClick={() => handleButtonClick(col)}
            >
              {col === "Backspace" ? (
                <FontAwesomeIcon icon={faBackspace} />
              ) : col === "Enter" ? (
                <FontAwesomeIcon icon={faArrowRight} />
              ) : (
                col
              )}
            </button>
          ))}
        </div>
      ))}
    </div>
  );
};

export default Keyboard;

