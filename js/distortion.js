const images = [
  "img/max/tiger.png",
  "img/max/horse.png",
];


rgbKineticSlider = new rgbKineticSlider({
  slideImages: images, // array of images > must be 1920 x 1080
  // itemsTitles: texts, // array of titles / subtitles

  backgroundDisplacementSprite: 'https://images.unsplash.com/photo-1508245678413-6b39322ae790?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MzB8fGNsb3VkJTIwdGV4dHVyZXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60', // slide displacement image 
  cursorDisplacementSprite: 'https://images.unsplash.com/photo-1500491460312-c32fc2dbc751?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80', // cursor displacement image 

  cursorImgEffect : true, // enable cursor effect
  cursorTextEffect : false, // enable cursor text effect
  cursorScaleIntensity : 0.85, // cursor effect intensity
  cursorMomentum : 0.09, // lower is slower

  swipe: true, // enable swipe
  swipeDistance : window.innerWidth * 0.5, // swipe distance - ex : 580
  swipeScaleIntensity: 1.66, // scale intensity during swipping

  slideTransitionDuration : 1, // transition duration
  transitionScaleIntensity : 10, // scale intensity during transition
  transitionScaleAmplitude : 100, // scale amplitude during transition

  imagesRgbEffect : true, // enable img rgb effect
  imagesRgbIntensity : 0.09, // set img rgb intensity
  navImagesRgbIntensity : 40, // set img rgb intensity for regular nav

  textsDisplay : false, // show title
  textsSubTitleDisplay : false, // show subtitles
  textsTiltEffect : false, // enable text tilt
  // buttonMode : false, // enable button mode for title
  // textsRgbEffect : true, // enable text rgb effect
  // textsRgbIntensity : 0.09, // set text rgb intensity
  // navTextsRgbIntensity : 10, // set text rgb intensity for regular nav

  // textTitleColor : 'white', // title color
  // textTitleSize : 125, // title size
  // mobileTextTitleSize : 45, // title size
  // textTitleLetterspacing : 3, // title letterspacing

  // textSubTitleColor : 'white', // subtitle color ex : 0x000000
  // textSubTitleSize : 21, // subtitle size
  // mobileTextSubTitleSize : 14,
  // textSubTitleLetterspacing : 3, // subtitle letter spacing
  // textSubTitleOffsetTop : 90, // subtitle offset top
  // mobileTextSubTitleOffsetTop : 50,
});