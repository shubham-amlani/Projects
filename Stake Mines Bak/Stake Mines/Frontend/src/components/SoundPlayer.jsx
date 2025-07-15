import { Howl } from 'howler';

export const playSound = (src) => {
  const sound = new Howl({
    src: [src],
  });
  sound.play();
};
