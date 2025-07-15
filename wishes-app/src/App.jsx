import { useEffect, useRef, useState } from "react";
import "./App.css";
import krishnaSVG from "./assets/krishna.svg";
import featherSVG from "./assets/peacock-feather.svg";

function App() {
  const [verses, setVerses] = useState([]);
  const [translations, setTranslations] = useState([]);
  const [commentaries, setCommentaries] = useState([]);
  const [currentVerse, setCurrentVerse] = useState(null);

  const [isPlaying, setIsPlaying] = useState(false);
  const [showApp, setShowApp] = useState(false);
  const audioRef = useRef(null);

  // Fetch JSON files once
  useEffect(() => {
    Promise.all([
      fetch("/data/verse.json").then((res) => res.json()),
      fetch("/data/translation.json").then((res) => res.json()),
      fetch("/data/commentary.json").then((res) => res.json()),
    ]).then(([verseData, translationData, commentaryData]) => {
      setVerses(verseData);
      setTranslations(translationData);
      setCommentaries(commentaryData);

      const random = verseData[Math.floor(Math.random() * verseData.length)];
      setCurrentVerse(random);
    });
  }, []);

  // Get a new random verse
  const showRandomVerse = () => {
    const random = verses[Math.floor(Math.random() * verses.length)];
    setCurrentVerse(random);
  };

  // Get preferred translation
  const getTranslation = (verseId) => {
    const eng = translations.find(
      (t) => t.verse_id === verseId && t.lang.toLowerCase() === "english"
    );
    const hindi = translations.find(
      (t) => t.verse_id === verseId && t.lang.toLowerCase() === "hindi"
    );
    return eng?.description || hindi?.description || "Translation not found";
  };

  // Get preferred commentary
  const getCommentary = (verseId) => {
    const eng = commentaries.find(
      (c) => c.verse_id === verseId && c.lang.toLowerCase() === "english"
    );
    const hindi = commentaries.find(
      (c) => c.verse_id === verseId && c.lang.toLowerCase() === "hindi"
    );
    return eng?.description || hindi?.description || "Commentary not found";
  };

  const toggleMusic = () => {
    if (!audioRef.current) return;
    if (isPlaying) {
      audioRef.current.pause();
    } else {
      audioRef.current.play();
    }
    setIsPlaying(!isPlaying);
  };

  // 🎂 Check for birthday (14 July)
  const today = new Date();
  const isBirthday = today.getDate() === 17 && today.getMonth() === 6;

  // Birthday screen
  if (isBirthday && !showApp) {
    return (
      <div className="birthday-container">
        <img
          src={featherSVG}
          alt="Peacock Feather"
          className="birthday-feather"
        />
        <img src={krishnaSVG} alt="Krishna" className="birthday-krishna" />

        <h1 className="bday-heading">🎉 Happy Birthday Disha! 🎂</h1>

        <p className="birthday-message">
          On this sacred day, may Lord Krishna bless your soul with divine love,
          inner peace, and boundless joy.
        </p>

        {/* Personal Thank You Message */}
        <div className="personal-message-box">
          <p className="birthday-message">
            On your special day I want to thank you. Dealing with that kitty is not easy, still you stood for me, argued with her, explained to her. Thank you so much for being my information carrier 😂
            <br />
            <br />
            Your support in that phase of my life meant more than I could ever
            express. Thank you for unveiling the truth at right times and help me navigate my way out this dark tunnel. Well I still wish to go back in, wish me luck I don't get lost again. 
            After all this...kitty still has the audacity to say "I am always right" 😂
            <br />
            PS: Ho sake to usse samjhana...🤧
            <br />
            <br />
            May Lord Krishna bless you endlessly for the love and clarity you've
            given — not just to me, but to everyone lucky enough to know you.
          </p>
          <p className="birthday-sign">
            Happy Birthday, Disha 🌸
            <br />
            With immense gratitude,
            <br />~ Shubham
          </p>
        </div>

        <div className="birthday-buttons">
          <button onClick={toggleMusic}>
            {isPlaying ? "⏸️ Stop Flute" : "🎶 Play Flute"}
          </button>
          <button onClick={() => setShowApp(true)}>🌼 Surpriseee!!! 🌼</button>
        </div>

        <audio ref={audioRef} loop>
          <source src="/flute.mp3" type="audio/mpeg" />
        </audio>
      </div>
    );
  }

  // Main App (normal or after birthday screen)
  return (
    <div className="container">
      <img src={featherSVG} alt="Peacock Feather" className="corner-feather" />
      <h1>📜 Bhagavad Gita Shlok</h1>

      {currentVerse ? (
        <div className="shlok-box">
          <h2>
            📖 Chapter {currentVerse.chapter_number}, Verse{" "}
            {currentVerse.verse_number}
          </h2>
          <p className="sanskrit">{currentVerse.text}</p>
          <p className="transliteration">
            <em>{currentVerse.transliteration}</em>
          </p>
          <p className="translation">
            <strong>Translation:</strong>
            <br />
            {getTranslation(currentVerse.verse_id)}
          </p>
          {/* <p className="commentary">
            <strong>Commentary:</strong><br />
            {getCommentary(currentVerse.verse_id)}
          </p> */}
        </div>
      ) : (
        <p>Loading verse...</p>
      )}

      <div className="app-buttons">
        <button onClick={showRandomVerse}>🔁 Show Another Shlok</button>
        <button onClick={toggleMusic}>
          🎶 {isPlaying ? "Stop Flute" : "Play Flute"}
        </button>
      </div>

      <audio ref={audioRef} loop>
        <source src="/flute.mp3" type="audio/mpeg" />
      </audio>
      <p>Click on the button to choose a random verse.</p>
    </div>
  );
}

export default App;
