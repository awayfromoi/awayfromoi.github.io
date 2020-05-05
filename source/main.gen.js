fs=require("fs");
curdir=fs.readdirSync(".");
mi=new require("markdown-it")();

//define startWith and endWith
String.prototype.startWith=function(s){return(new RegExp("^"+s)).test(this);}
String.prototype.endWith=function(s){return(new RegExp(s+"$")).test(this);}

meta="";
bookmarx=[];
function make_escape(s){
    let t="";
    for(let i=0;i<s.length;i++){
        if(s[i]=="\"")t+="&quot;";
        else if(s[i]==" ")t+=" ";
        else if(s[i]=="&")t+="&amp;";
        else if(s[i]=="<")t+="&lt;";
        else if(s[i]==">")t+="&gt;";
        else t+=s[i];
    }
    return t;
}
function rec_proc(s){
    let tt=s;
    let ttraw=s;
            let tit="";
            if(meta!=undefined&&typeof(meta.title)=="string")
                tit=make_escape(meta.title);
            let bookht="";
            if(bookmarx.length>=0){
                bookht+="<a href=\"javascript:;\" onclick=\"javascript:close_content();\" class=\"close-content\">关闭目录</a><br>";
            }
            for(let i=0;i<bookmarx.length;i++){
                let lev=bookmarx[i][0];let v=bookmarx[i][1];
                bookht+="<a href=\"#bm"+(i+1)+"\" onclick=\"javascript:close_content();\">"+rep_str("&nbsp;",6*(lev-1))+v.trim()+"</a><br>";
            }
            let ret="<!DOCTYPE html><html><title>"+tit+` - Away from OI</title>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,  initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />`
        ret+=`<link rel="stylesheet" type="text/css" href="emerg.css">`;
	ret+=`<link rel="stylesheet" type="text/css" href="ferrous.css">`
	ret+=`
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gitalk@1/dist/gitalk.css">
	<script src="https://cdn.jsdelivr.net/npm/gitalk@1/dist/gitalk.min.js"></script>
	<link href="icon.png" rel="Shortcut Icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.10.0-rc.1/katex.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.10.0-rc.1/katex.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.10.0-rc.1/contrib/auto-render.js"></script>
        <link href="https://cdn.bootcss.com/highlight.js/8.0/styles/monokai_sublime.min.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/highlight.js/8.0/highlight.min.js"></script>
        <script src="https://ajax.proxy.ustclug.org/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

        `
	if(meta.emerg)ret+=`<body id="body" class="emerg">`
	else ret+=`<body id="body">`
    if(meta.filename.startWith("indexen")){
        ret+=`
<div class="frontpage"><div class="frontpage-overlay"><div class="frontpage-inner container"><h1>Away from OI</h1><strong>Being away from OI may seem to be great loss, but you don't have to deal with it alone.</strong><a class="primary" onclick="close_front()">Learn More</a></div></div></div>`;
    }
    if(meta.filename.startWith("index")){
        ret+=`
<div class="frontpage"><div class="frontpage-overlay"><div class="frontpage-inner container"><h1>Away from OI</h1><strong>OI退役也许让你失去了很多，但是你不必独自面对。</strong><a class="primary" onclick="close_front()">Learn More</a></div></div></div>`;
    }
	ret+=`
        <div class="top-bar">
        <a href="`;
	if(meta.filename&&(meta.filename.startWith("en")||meta.filename.startWith("indexen")))ret+="indexen.html";else ret+="index.html";
	ret+=`" class="tpi icon-top primary"><img src="home.svg" class="svg"></a>
        <p class="tpi">`+tit+`</p>
        <a href="javascript:;" onclick="javascript:open_content();" class="tpi icon-top"><img src="top.svg" class="svg"></a></div>
        `;
        if(true)ret+=`<div class="article">`+tt+`</div>`;
        else ret+=tt;
        ret+=`<nav id="table-content">`+bookht+`</nav>`;
        ret+=`
<div id="gitalk-container" class="container"></div>`;
	ret+=`
	<script>

if(location.href.substr(0,5)=="file:"||location.hostname.substr(0,3)=="127"){
    $("#gitalk-container").css("display","none");}else{
const gitalk = new Gitalk({
  clientID: '133aa544ab7aacc0e908',
  clientSecret: 'fe362d1dd84949381a7cb9bc6701219881316394',
  repo: 'afogi-comment',
  owner: 'awayfromoi',
  admin: ['awayfromoi','ferrumcccp'],
  id: location.pathname,
  distractionFreeMode: false
})
gitalk.render('gitalk-container')
}
	</script>
    <!-- 1-800-273-8255
    <iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=86 src="https://music.163.com/outchain/player?type=2&id=518077470&auto=1&height=66" class="embed-player"></iframe>-->
	<div id="gitalk-container"></div>
	<footer>
        <script src="wycero-1.js"></script>
        <p>Copyright `+new Date().getFullYear()+` wycero</p>
        <p>Powered By:
        <a href="http://nodejs.org">Node.js</a>
        <a href="https://katex.org">$\\KaTeX$</a>
        <a href="https://highlightjs.org/">Highlightjs</a></p>
        <p>Hosted On coding.me</p>
        </footer>
        <script >hljs.initHighlightingOnLoad();</script>
        <script>
            renderMathInElement(document.body,
           {
                      delimiters: [
                          {left: "$$", right: "$$", display: true},
                          {left: "$", right: "$", display: false}
                      ]
                  }
          );
        </script>`+"</body></html>";
        return ret;
}
pages=[];
function arr_proc(s){
    if(meta==undefined||meta.filename=="");else{
        pages.push(meta);
    }
    return rec_proc(s);
}
function proc(s,filename){
    var i=0;
    meta=undefined;
    if(s[0]=="@"){
        meta="";
        for(i=1;i<s.length;i++){
            if(s[i]=="\r"||s[i]=="\n")break;
            meta+=s[i];
        }
    }
    if(meta)meta=JSON.parse(meta);
    meta.filename=filename;
    console.log(meta);
    while(i<s.length&&(s[i]=="r"||s[i]=="\n"))i++;
    return arr_proc(mi.render(s.substr(i)));
}
function htmlize(s){
    if(s.endWith(".txt"))return s.substr(0,s.length-4)+".html";
    else if(s.endWith(".md"))return s.substr(0,s.length-3)+".html";
}
for(let i=0;i<curdir.length;i++){
    if(curdir[i].endWith(".txt")||curdir[i].endWith(".md")){
        console.log("Proceeding BBCODE: "+curdir[i]);
        fs.writeFileSync("../blog/"+htmlize(curdir[i]),proc(fs.readFileSync(curdir[i],"utf8"),htmlize(curdir[i])));
    }else if((!curdir[i].endWith(".gen.js"))&&(curdir[i]!="g")){
        console.log("Copying File: "+curdir[i]);
        fs.writeFileSync("../blog/"+curdir[i],fs.readFileSync(curdir[i]));
    }else console.log("Skipping: "+curdir[i]);
}
// Sorry4hardcoding
index_page=`@{"title":"首页"}
# Away from OI
**OI退役也许让你失去了很多，但是你不必独自面对。**

告诉您的父母和老师您正在经历的事情，并向他们寻求建议。 他们可能会更多地了解当前的状况以及如何应对压力。

您也可以浏览该网站。 虽然该网站仍在开发中，但我希望您能从中获得帮助。亲爱的读者们，同是退役 OIer，**我们可以互相帮助！**

如果您无法应对失去，例如长时间处于沮丧状态或正在考虑自杀，**请寻求专业帮助。**
`;
indexen=`@{"title":"Home"}
# Away from OI
**Being away from OI may seem to be great loss, but you don't have to deal with it alone.**

Tell your parents and teachers about what you are going through and ask them for advice. They may know more about the present situation and how to deal with stress.

You can also have a look at this website. Though this website is a work in progress, I hope you can get help from it. My dear readers, as we are all former competitive programmers, **we can help each other!**

If you are not coping with the loss, for example you are feeling down over a long period of time or you are thinking about suicide, **seek professional help.**
`
for(let i=0;i<pages.length;i++){
	if(pages[i].hidden)continue;
	let ub="- ["+pages[i].title+"]("+pages[i].filename+")\n";
	if(pages[i].filename.startWith("en"))indexen+=ub;
	else if(pages[i].filename.startWith("multi")){index_page+=ub;indexen+=ub;}
	else index_page+=ub;
}
fs.writeFileSync("../blog/index.html",proc(index_page,"index.html"));
fs.writeFileSync("../blog/indexen.html",proc(indexen,"indexen.html"));

