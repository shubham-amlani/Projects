import React from "react";
import "../styles/Grid.css";

const Grid = ({ grid, currentRow, currentColumn }) => {
  return (
    <div className="grid-container">
      {grid.map((row, rowIndex) => (
        <div key={rowIndex} className="grid-row">
          {row.map((cell, colIndex) => {
            const isCurrentCell = rowIndex === currentRow && colIndex === currentColumn;
            return (
              <div
                key={colIndex}
                id={`cell-${rowIndex}-${colIndex}`} // Ensure id is unique for each cell
                className="grid-cell-container" // Wrapper for the flip effect
              >
                <div
                  className={`grid-cell ${cell.status} ${
                    isCurrentCell ? "current-cell pop" : ""
                  }`} // Apply status, current-cell, and pop classes
                >
                  <div className="grid-cell-front">{cell.letter}</div>
                  <div className="grid-cell-back">
                    {/* Optionally, display something like '✔' for correct, etc. */}
                    {cell.status === "correct"
                      ? "✔"
                      : cell.status === "present"
                      ? "↔️"
                      : "❌"}
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      ))}
    </div>
  );
};

export default Grid;
