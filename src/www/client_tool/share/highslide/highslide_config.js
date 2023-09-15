hs.registerOverlay({
	html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
	position: 'top right',
	fade: 2 // fading the semi-transparent overlay looks bad in IE
});

hs.graphicsDir = '../share/highslide/graphics/';
hs.outlineType = 'rounded-white';
//hs.wrapperClassName = 'borderless';


/*
��outlineType������

outlineType�Ǥϡ��Ȳ����Υ����פ�����Ǥ��ޤ���
����Ǥ����ͤ������ϲ������̤�Ǥ���
oulineType���������

'rounded-white'
    �Ѵݤ�����
'rounded-black'
    �Ѵݤι�����
'glossy-dark'
    ���Ω�δ��Τ��������
'outer-glow'
    �ȼ��Τ����ä������ʥ����Ȥ��طʤ����뤤���ϡ�dimmingOpacity��ʻ�Ѥ���ȸ���Ū��
'beveled'
    ���Ω�δ��Τ���ȾƩ����ȡ�dimmingOpacity��ʻ�Ѥ���ȸ���Ū��
'drop-shadow'���ޤ��ϡ�null
    �ǥե���Ȥ������͡�outlineType�����ꤷ�ʤ����ϡ����줬���ꤵ��Ƥ��ޤ���





��wrapperClassName������

wrapperClassName�ϡ��Ȳ�����outlineType�ΰ�ˤ���¦�Υ١����Ȥʤ�CSS�Υ��饹̾����ꤹ������Ǥ���

����Ǥ����ͤ������ϲ������̤�Ǥ���
wrapperClassName���������

'borderless'
    �������Ȥʤ�
'wide-border'
    �岼����10px���ط�����ȡ�CSS�� .wide-border
'colored-border'
    �����ο��ȡʽ���� green �ˡ�CSS�� .colored-border��ʬ���ѹ�����п��ѹ��Ǥ��ޤ���
'dark'
    outlineType��'glossy-dark'�����ꤷ����硣rounded-black���Ȥ߹�碌�Ƥ��ɤ��������ο����㴳�㤦�ʿ� #111��
'glossy-dark'
    �����ϡ�outlineType��glossy-dark�ȥ���ӤǤ��ä����ꡣCSS�ηѾ���ʬ����ʤ����ϡ�'dark'��侩
'outer-glow'
    outlineType��'outer-glow'�����ꤷ����硣�ȿ�#444444
'floating-caption'
    caption�ʲ���������ʸ��ɽ����ʬ���Ȥγ�¦��ɽ����������(dimmingOpacity��ʻ�Ѥ���ȸ���Ū��
'draggable-header'
    ���iframe��flash��youtube��ɽ���κݤ˻��ѡ�htmlExpand��
'controls-in-heading'
    slideshow�⡼�ɤ���Ѥ���ݤ�ɽ������륳��ȥ���С�������ξ�����ɽ���������� 
    
 
*/