var context = new webkitAudioContext(),
oscillator = context.createOscillator();

oscillator.connect(context.destination); // Connect to speakers
oscillator.start(0); // Start generating sound immediately

oscillator.type = 3; // Tell the oscillator to use a square wave
oscillator.frequency.value = 55; // in hertz