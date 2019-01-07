<?php
use function OctoberFa\Virastar\virastar;
use PHPUnit\Framework\TestCase;

class VirastarTest extends TestCase
{
    public function testNormalize_eol()
    {
        $this->assertEquals(virastar("تست\r\nخط جدید") , "تست\nخط جدید");
    }
    public function testDecode_htmlentities()
    {
        $this->assertEquals(virastar("&#62;") , ">");
    }
    public function testFix_dashes()
    {
        $this->assertEquals(virastar("--") , "–");
        $this->assertEquals(virastar("---") , "—");
    }
    public function testFix_three_dots()
    {
        $this->assertEquals(virastar("...") , "…");
    }
    public function testFix_english_quotes_pairs()
    {
        $this->assertEquals(virastar("“تست”") , "«تست»");
    }
    public function test2()
    {
        $text = <<< pol
      ويراستار به شما كمك مي كند تا متون فارسي زيبا تر و درست تري بنويسيد .

ويراستار به طور پيش فرض اين کار ها را انجام می دهد :
1. نویسه های عربي را به فارسی تبديل مي کند.  مثلا كاف و ياي عربي .
2. نویسه های انگليسي رايج در تايپ فارسي را به معادل صحيح فارسي آن تبدیل می کند, مثلا تبدیل کامای انگلیسی به ویرگول (,), يا نقطه ویرگول به جای semicolon (;) و یا استفاده از "گيومه های فارسي"
3. اعداد عربي و انگليسي و علائم رياضی را به معادل فارسی آن ها تبديل مي کند.    مثلا  :  12%  456
4. سه نقطه را به نويسه صحيح آن که تنها يك نويسه است تبديل کرده و فاصله گذاري آن را اصلاح مي کند ...
5. در ترکيباتي مانند ''خانه ي پدری'' که  با "ه" تمام می‌شوند نشانه "ی" كسره ی اضافه را به "هٔ" تبديل می كند.
6. دو علامت منهاي پي در پي را به خط کشيده کوتاه (--) و سه علامت منهاي پي در پي را به خط کشیده بلند (---) تبديل مي كند .
7. فاصله گذاری را تصحيح مي کند . بين هر کلمه تنها یک فاصله و بین پیشوندها و پسوندهاي مانند "مي","تر"و"ترین"  يک نيم فاصله قرار مي دهد.  بین ویرگول یا نقطه و کلمه قبل آن فاصله را حذف می کند.
8. فاصله گذاری را برای متون بین "  گیومه  " , {    آکولاد   }  , [   کروشه  ]  و ( پرانتز    ) تنظيم مي کند .
9. علامت تعحب و سوال اضافی را حذف مي کند؟؟؟!!!!!!!
pol;
        $expect = 'ویراستار به شما کمک می‌کند تا متون فارسی زیبا‌تر و درست‌تری بنویسید. 

ویراستار به طور پیش فرض این کار‌ها را انجام می‌دهد: 
1. نویسه‌های عربی را به فارسی تبدیل می‌کند. مثلا کاف و یای عربی. 
2. نویسه‌های انگلیسی رایج در تایپ فارسی را به معادل صحیح فارسی آن تبدیل می‌کند، مثلا تبدیل کامای انگلیسی به ویرگول (، )، یا نقطه ویرگول به جای semicolon (؛ ) و یا استفاده از «گیومه‌های فارسی» 
3. اعداد عربی و انگلیسی و علایم ریاضی را به معادل فارسی آن‌ها تبدیل می‌کند. مثلا: ۱۲٪ ۴۵۶
4. سه نقطه را به نویسه صحیح آن که تنها یک نویسه است تبدیل کرده و فاصله گذاری آن را اصلاح می‌کند…
5. در‌ترکیباتی مانند «خانهٔ پدری» که با «ه» تمام میشوند نشانه «ی» کسرهٔ اضافه را به «هٔ» تبدیل می‌کند. 
6. دو علامت منهای پی در پی را به خط کشیده کوتاه (–) و سه علامت منهای پی در پی را به خط کشیده بلند (—) تبدیل می‌کند. 
7. فاصله گذاری را تصحیح می‌کند. بین هر کلمه تنها یک فاصله و بین پیشوندها و پسوندهای مانند «می»، «تر» و «ترین» یک نیم فاصله قرار می‌دهد. بین ویرگول یا نقطه و کلمه قبل آن فاصله را حذف می‌کند. 
8. فاصله گذاری را برای متون بین «گیومه»، {آکولاد}، [کروشه] و (پرانتز) تنظیم می‌کند. 
9. علامت تعحب و سوال اضافی را حذف می‌کند؟!';

        $this->assertEquals(virastar($text, ['preserve_brackets' => false, 'preserve_braces' => false]), $expect);
    }
}