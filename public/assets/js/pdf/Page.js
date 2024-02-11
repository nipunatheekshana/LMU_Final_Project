console.log('Page.js')
class Page {

    static EVERY = true;
    static SINGLE = false;

    constructor() {
        this.PageSize = 'A4';
        this.PageOrientation = 'portrait';
        this.PageMargin = [40, 60, 40, 60];
        this.Title = null;
        this.Logo = null;
        this.Header = {
            content: null,
            flag: Page.EVERY,
        };
        this.Body = null;
        this.Footer = null;
    }

    setPageSize(size) {
        this.PageSize = size;
    }

    setPageOrientation(orientation) {
        this.PageOrientation = orientation;
    }

    setPageMargin(margin) {
        this.PageMargin = margin;
    }

    setTitle(title) {
        this.Title = title;
    }


    setHeader(header, Flag) {
        this.Logo = header[0].logo;
        this.Header.content = header[0].content;
        this.Header.flag = Flag;
    }

    setBody(body) {
        this.Body = body;
    }

    setFooter(footer) {
        this.Footer = footer;
    }


    preview() {
        this.makePDF(this);
    }


    makePDF(page) {

        if (page.Logo != null) {
            const img = new Image();
            img.src = page.Logo.path;
            img.addEventListener('load', function (event) {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = event.currentTarget.width;
                canvas.height = event.currentTarget.height;
                ctx.drawImage(event.currentTarget, 0, 0);
                const dataurl = canvas.toDataURL('image/jpeg');
                PDFViewer(page.Title, page.Header, { "image": dataurl, 'width': page.Logo.width, 'height': page.Logo.height, 'alignment': page.Logo.alignment }, page.Body, page.Footer);

            });
        } else {
            PDFViewer(page.PageSize, page.PageOrientation, page.Title, page.Header, null, page.Body, page.Footer,page.PageMargin);
        }
    }

}
