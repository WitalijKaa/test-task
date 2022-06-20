class MiniTaskController {

    canvasBig;
    canvasBigContext;
    canvasSmall;
    canvasSmallContext;

    beforeActions() {
        this.canvasBig = document.getElementById('cBig');
        this.canvasBigContext = this.canvasBig.getContext('2d');
        this.canvasSmall = document.getElementById('cSmall');
        this.canvasSmallContext = this.canvasSmall.getContext('2d');

        this.canvasBig.addEventListener(
            "click",
            (event) => {
                this.fillCanvas(
                    this.canvasSmall,
                    this.canvasSmallContext,
                    this.canvasClickColor(event, this.canvasBigContext)
                );
            },
            false
        );
    }

    actionStars() {
        this.fillCanvas(this.canvasBig, this.canvasBigContext, 'white')
        this.fillCanvas(this.canvasSmall, this.canvasSmallContext, 'white')
        this.drawStar('#f44336', [10, 10], 200);
        this.drawStar('#3f51b5', [300, 10], 200);
        this.drawStar('#8bc34a', [10, 300], 200);
        this.drawStar('#ff5722', [300, 300], 200);
        this.drawStar('#37474f', [150, 150], 200);
    }

    drawStar(color, offset, size) {
        const context = this.canvasBigContext;
        context.fillStyle = color;
        context.beginPath();
        this.drawStarPath(offset, size, context);
        context.closePath();
        context.fill();
    }

    drawStarPath(offset, size, ctx) {
        let method = 'moveTo';
        let mult = size / 220;
        this.someStarFromInternet.map((poss) => {
            ctx[method](offset[0] + poss[0] * mult, offset[1] + poss[1] * mult);
            method = 'lineTo'
        })
    }

    canvasClickColor(event, context) {
        let pixel = context.getImageData(event.offsetX, event.offsetY, 1, 1).data;
        return this.rgbToHex(pixel[0], pixel[1], pixel[2]);
    }

    fillCanvas(canvas, context, color) {
        context.fillStyle = color;
        context.fillRect(0, 0, canvas.width, canvas.height);
    }

    numberToHex(c) {
        let hex = c.toString(16);
        return hex.length == 1 ? "0" + hex : hex;
    }

    rgbToHex(r, g, b) {
        return "#" + this.numberToHex(r) + this.numberToHex(g) + this.numberToHex(b);
    }

    someStarFromInternet = [ // looks like 218 original size
        [108, 0.0],
        [141, 70],
        [218, 78.3],
        [162, 131],
        [175, 205],
        [108, 170],
        [41.2, 205],
        [55, 131],
        [1, 78],
        [75, 68],
        [108, 0],
    ];
}