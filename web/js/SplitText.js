///////////////////////////////      PLUGIN         //////////////////////////////

(function ($) {

    $.fn.splitText = function (options) {

        // options //
        // type = 'lines','words','letters', 'sentences' (new) 


        // default
        var opts = {
            'mainClass': 'splitText',
            'types': ['letters', 'words', 'lines'],
            'classes': {'lines': 'line', 'letters': 'letter', 'words': 'word', 'blank': 'blank'},
            'tags': {'lines': 'div', 'letters': 'div', 'words': 'div', 'blank': 'div'},
        };

        if ($.isEmptyObject(options)) {
            options = opts;
        }
        if (($.inArray('words', options.types) != -1 && $.inArray('letters', options.types) != -1 && $.inArray('lines', options.types) != -1)) {
            options.types = opts.types;
        }
        if ($.isEmptyObject(options.mainClass)) {
            options.mainClass = opts.mainClass;
        }
        if ($.isEmptyObject(options.classes)) {
            options.classes = opts.classes;
        }
        if ($.isEmptyObject(options.classes.letters)) {
            options.classes.letters = opts.classes.letters;
        }
        if ($.isEmptyObject(options.classes.words)) {
            options.classes.words = opts.classes.words;
        }
        if ($.isEmptyObject(options.classes.lines)) {
            options.classes.lines = opts.classes.lines;
        }
        if ($.isEmptyObject(options.classes.blank)) {
            options.classes.blank = opts.classes.blank;
        }
        if ($.isEmptyObject(options.tags)) {
            options.tags = opts.tags;
        }
        if ($.isEmptyObject(options.tags.words)) {
            options.tags.words = opts.tags.words;
        }
        if ($.isEmptyObject(options.classes.lines)) {
            options.tags.lines = opts.tags.lines;
        }
        if ($.isEmptyObject(options.classes.blank)) {
            options.tags.blank = opts.tags.blank;
        }

        // element is the outer container //
        var element = $(this);
       

        // adding css for global tag
        element.addClass(options.mainClass);

        text = formatAll(element.text());






        element.empty();
        element.html(text);


        /////////////////////////////////////////////////////////////////////
        function formatAll(text) {
            var lines = text.split("\n"), words = [], letters = [],output;
            for (var i = 0; i < lines.length; i++) {
                words = lines[i].split(" ");
                for (var j = 0; j < words.length; j++) {
                    letters = words[j].split("");
                    if ($.inArray('letters', options.types) != -1) {
                        for (var k = 0; k < letters.length; k++) {
                            if (!letters[k].match(/\s\n\t\r/g) && letters[k] != "")
                                letters[k] = '<'+options.tags.letters+' class="' + options.classes.letters + '">' + letters[k] + '</'+options.tags.letters+'>';
                        }
                    }
                    words[j] = letters.join("");
                    if ($.inArray('words', options.types) != -1) {
                        words[j] = '<'+options.tags.words+' class="' + options.classes.words + '">' + words[j] + '</'+options.tags.words+'>';
                    }
                }
                lines[i] = words.join('<'+options.tags.blank+' class="' + options.classes.blank + '"> </'+options.tags.blank+'>');
                if ($.inArray('lines', options.types) != -1) {
                    lines[i] = '<'+options.tags.lines+' class="' + options.classes.lines + '">' + lines[i] + '</'+options.tags.lines+'>';
                }
            }
            return lines.join("");
        }
//        function splitWords(text) {
//            return text.split(" ");
//        }
//        function splitLetters(arr) {
//            for (var i = 0; i < arr.length; i++) {
//                var arr2 = arr[i].split("");
//                arr[i] = [];
//                for (var j = 0; j < arr2.length; j++) {
//                    arr[i][j] = arr2[j];
//                    letters.push(arr2[j]);
//
//                }
//            }
//            return arr;
//        }
//
//        function formatAll(arr) {
//            for (var i = 0; i < arr.length; i++) {
//                if ($.inArray('letters', options.types) != -1) {
//                    arr[i] = formatLetters(arr[i]);
//                } else {
//                    arr[i] = arr[i].join("");
//                }
//            }
//            if ($.inArray('words', options.types) != -1) {
//                return formatWords(arr);
//            }
//            return arr.join('<div class="' + options.classes.blank + '"> </div>');
//
//
//        }
//
//
//        function formatLetters(arr) {
//            for (var i = 0; i < arr.length; i++) {
//
//                if (!arr[i].match(/\s\n\t\r/g) && arr[i] != "")
//                    arr[i] = '<div class="' + options.classes.letters + '">' + arr[i] + '</div>';
//            }
//            return arr.join("");
//        }
//
//        function formatWords(arr) {
//            for (var i = 0; i < arr.length; i++) {
//                arr[i] = '<div class="' + options.classes.words + '">' + arr[i] + '</div>';
//            }
//            return arr.join('<div class="' + options.classes.blank + '"> </div>');
//        }

//        function splitLines() {
//            var count = element.children(".word").length;
//            var lineAcc = [element.children(".word:eq(0)").text()];
//            var textAcc = [];
//            for (var i = 1; i < count; i++) {
//                var prevY = element.children(".word-measure:eq(" + (i - 1) + ")").offset().top;
//                if (element.children(".word-measure:eq(" + i + ")").offset().top == prevY) {
//                    lineAcc.push(element.children(".word-measure:eq(" + i + ")").text());
//                }
//                else {
//                    textAcc.push({text: lineAcc.join(" "), top: prevY});
//                    lineAcc = [element.children(".word-measure:eq(" + i + ")").text()];
//                }
//            }
//            textAcc.push({text: lineAcc.join(" "), top: element.children(".word-measure:last").offset().top});
//            return textAcc;
//        }

//        function splitSentences(text) {
//
//            var regExp = /[^\.!\?]+[\.!\?]+/g;
//
//            var words = splitWords(text, true);
//
//            var sentencesArr = String(text).match(regExp);
//            var textAcc = new Array();
//
//            for (var i = 0; i < sentencesArr.length; i++) {
//                textAcc.push({'text': sentencesArr[i]});
//            }
//
//
//            textAcc = new Array();
//
//            for (var j = 0; j < words.length; j++) {
//                var word = words[j];
//                isSentenceEnd = regExp.test(word);
//                if (isSentenceEnd) {
//                    words[j] = "<div class='split-sentences endOfSentence'>" + word + "</div>";
//                }
//                else {
//                    words[j] = "<div class='split-sentences'>" + word + "</div>";
//                }
//
//                textAcc.push(words[j]);
//
//            }
//
//            var arr = words.join(" ");
//            return arr;
//
//
//        }






        return this;
    };






})(jQuery);