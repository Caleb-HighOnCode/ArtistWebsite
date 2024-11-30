const NUM_ROWS = 3;
const NUM_IMAGES = 540;
let IMAGES = [
  'img/low/1.png',
  'img/low/2.png',
  'img/low/3.png',
  'img/low/4.png',
  'img/low/5.png',
  'img/low/6.png',
  'img/low/7.png',
  'img/low/8.png',
  'img/low/9.png',
  'img/low/a.png',
  'img/low/b.png',
  'img/low/c.png',
  'img/low/d.png',
  'img/low/e.png',
  'img/low/f.png',
  'img/low/g.png',
  'img/low/h.png',
  'img/low/i.png',
  'img/low/j.png',
  'img/low/k.png',
  'img/low/l.png',
  'img/low/m.png',
  'img/low/n.png',
  'img/low/o.png',
  'img/low/p.png',
  'img/low/q.png',
  'img/low/r.png',
  'img/low/t.png',
  'img/low/u.png',
  'img/low/v.png',
  'img/low/w.png',
  'img/low/x.png',
  'img/low/y.png',
  'img/low/z.png',
];

let imagesLen = 0;
while(imagesLen<NUM_IMAGES){
  IMAGES = [...IMAGES,...IMAGES]
  imagesLen= IMAGES.length;
}

IMAGES = IMAGES.splice(0,540);

// Populate images array
// for (let i = 0; i < NUM_IMAGES; i++) {
//   let width = (Math.floor(Math.random() * 3) + 2) * 100;
//   let height = (Math.floor(Math.random() * 3) + 2) * 100;
//   IMAGES.push(`http://unsplash.it/${width}/${height}`);
// }

let rows = [];
for (let i = 0; i < NUM_ROWS; i++) {
  let row = document.createElement("div");
  row.classList.add("footer-row");
  
  rows.push(row);
}

let wall = document.getElementById("footer-animated-wall");
for (let i = 0; i < IMAGES.length; i++) {
  let index = i % rows.length;
  let row = rows[index];
  let onBottomRow = index === rows.length - 1;
  if (onBottomRow) {
    let frame = document.createElement("div");
    frame.classList.add("footer-frame");
    frame.innerHTML = `
          <img src="${IMAGES[i]}">
          <div class="footer-reflection">
            <img src="${IMAGES[i]}">
          </div>
        `;
    row.appendChild(frame);
  } else {
    let img = document.createElement("img");
    img.src = IMAGES[i];
    row.appendChild(img);
  }
}

// Append rows to the wall and clone them for infinite scroll effect
rows.forEach((row) => {
  wall.appendChild(row.cloneNode(true)); // Clone and append to simulate infinite scroll
});
