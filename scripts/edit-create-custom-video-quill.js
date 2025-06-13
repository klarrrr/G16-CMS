const BlockEmbed = Quill.import('blots/block/embed');

// Custom Video Class
class CustomVideo extends BlockEmbed {
    static create(value) {
        const node = document.createElement('video');
        node.setAttribute('controls', true);
        node.setAttribute('width', '100%');
        node.setAttribute('height', '400');
        const source = document.createElement('source');
        source.setAttribute('src', value);
        source.setAttribute('type', 'video/mp4');
        node.appendChild(source);
        return node;
    }

    static value(node) {
        const source = node.querySelector('source');
        return source ? source.getAttribute('src') : '';
    }
}

CustomVideo.blotName = 'customVideo';
CustomVideo.tagName = 'video';

Quill.register(CustomVideo);