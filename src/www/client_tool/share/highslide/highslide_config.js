hs.registerOverlay({
	html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
	position: 'top right',
	fade: 2 // fading the semi-transparent overlay looks bad in IE
});

hs.graphicsDir = '../share/highslide/graphics/';
hs.outlineType = 'rounded-white';
//hs.wrapperClassName = 'borderless';


/*
■outlineTypeの設定

outlineTypeでは、枠画像のタイプを設定できます。
設定できる値と説明は下記の通りです。
oulineTypeの設定一覧

'rounded-white'
    角丸の白い枠
'rounded-black'
    角丸の黒い枠
'glossy-dark'
    やや立体感のある黒い枠
'outer-glow'
    枠自体が光った感じ（サイトの背景が明るい場合は、dimmingOpacityを併用すると効果的）
'beveled'
    やや立体感のある半透過の枠（dimmingOpacityを併用すると効果的）
'drop-shadow'　または　null
    デフォルトの設定値。outlineTypeを設定しない場合は、これが指定されています。





■wrapperClassNameの設定

wrapperClassNameは、枠画像（outlineType領域）の内側のベースとなるCSSのクラス名を指定する設定です。

設定できる値と説明は下記の通りです。
wrapperClassNameの設定一覧

'borderless'
    画像の枠なし
'wide-border'
    上下左右10px、背景白の枠。CSS内 .wide-border
'colored-border'
    画像の色枠（初期値 green ）。CSS内 .colored-border部分を変更すれば色変更できます。
'dark'
    outlineTypeで'glossy-dark'を設定した場合。rounded-blackと組み合わせても良いが、黒の色が若干違う（色 #111）
'glossy-dark'
    元々は、outlineTypeのglossy-darkとコンビであった設定。CSSの継承が分からない方は、'dark'を推奨
'outer-glow'
    outlineTypeで'outer-glow'を設定した場合。枠色#444444
'floating-caption'
    caption（画像の説明文）表示部分を枠の外側に表示する設定(dimmingOpacityを併用すると効果的）
'draggable-header'
    主にiframe・flash・youtubeの表示の際に使用（htmlExpand）
'controls-in-heading'
    slideshowモードを使用する際に表示されるコントロールバーを画像の上部に表示する設定 
    
 
*/