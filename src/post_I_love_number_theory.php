<!--
数论-从入门到出门
欢迎来到数论
-->
<?php
include'libs.php';
dochead("数论-从入门到出门");
auto_mk('p',<<<'EOP'
<h1>欢迎来到数论</h1>
既然是数论杂谈，就从一些基本概念讲起吧。dalao自行跳过
<h2>基本定义</h2>
整除：若$p,q,\frac q p\in \mathbb{Z}$，则$p\mid q$
同余：若$p,q\in\mathbb{Z},r\in\mathbb{Z^+},r\mid p-q$则$p\equiv q (\mathrm{mod}\ r)$
质数：若$p\in(1,+\infty)\cap\mathbb{Z^+},\forall q\in(1,p)\cap\mathbb{Z^+},q\nmid p$则$p$为质数
合数：若$p\in(1,+\infty)\cap\mathbb{Z^+},\exists q\in(1,p)\cap\mathbb{Z^+},q\mid p$则$p$为合数
gcd：$\mathrm{gcd}(x_1,x_2,\cdots x_n)=\max\{p\in\mathbb{N}{\large\mid}p\mid x_1,p\mid x_2\cdots p\mid x_n\}$
lcm：$\mathrm{lcm}(x_1,x_2,\cdots x_n)=\min\{p\in\mathbb{N}{\large\mid}x_1\mid p,x_2\mid p\cdots x_n\mid p\}$
<h2>基本定理</h2>
若$p|q,q|r$则$p|r$（显然）
[裴蜀定理]$gcd(a,b)|c\Leftrightarrow\exists x,y$使得$ax+by=c$
</p><blockquote><p>
必要性显然，以下证充分性。
若$b=0$则得证。
否则
$ax+[a(\lfloor b/a\rfloor)+(b\mod a)]y=c$
$a(x+\lfloor b/a\rfloor y)+(b\mod a)y=c$
由归纳法得证。
</p></blockquote></p>
若$p|qr,p\perp q$则$p|r$ 
</p><blockquote><p>
$\exists x,y$使得$px+qy=1$
$rpx+rqy=r$
$\because p|qr,p|pr$
$\therefore p|r$
</p></blockquote></p>
若$x$为合数，则$\exists$质数$p$，$p|x$（由合数定义及归纳法）
唯一分解定理：任何正整数能唯一分解成质数的乘积。
</p><blockquote><p>
反证，令$N=p_1p_2\cdots p_n=p'_1p'_2\cdots p'_m$
约掉重复的质因数后，设剩下的等式为$P_1P_2\cdots P_x=P'_1P'_2\cdots P'_y$
$\because P_1|P'_1P'_2\cdots P'_n$又$P_1\perp P'_1\cdots P_1\perp P'_n$
$\therefore$矛盾
</p></blockquote><p>
费马小定理：若$p$为质数$p\nmid x,x^{p-1}\equiv x(\mathrm{mod}\ p)$
欧拉定理：若$p\perp x,x^{\phi(p)}\equiv x(\mathrm{mod}\ p)$
Lucas定理：若$p$为质数$C^n_m\equiv C^{\lfloor n/p\rfloor}_{\lfloor m/p\rfloor}C^{n\mod p}_{m\mod p}(\mathrm{mod}\ p)$
<h1>基本算法</h1>
<h2>扩展欧几里德算法</h2>
参见裴蜀定理的证明
<h2>BSGS</h2>
已知$a,b,c$求$x$使$a^x=b(\mathrm{mod}\ c)$
取$m=\lceil\sqrt{C}\rceil$计算$a^m,a^{2m},a^{3m},\cdots$加入哈希表
计算$b^1,b^2,\cdots b^m$上哈希表查询
<h1> 咕咕咕咕咕咕！</h1>
<h1> 目标：狄利克雷生成函数</h1>
如果你去逛OEIS<del>找规律</del>，你也许会注意到一个东西：

Dirichlet g.f.: 啥啥啥

这就是狄利克雷生成函数（g.f=Generating function）
$L(s,\chi)=\sum\limits_{i=1}^{\infty} \frac{\chi_i}{i^s}(s\in\mathbb{C})$为数列$\chi$的狄利克雷生成函数（例如$\mu$的生成函数为$\sum\limits_{i=1}^\infty \frac{\mu_i}{i^s}$）
<h2> 黎曼$\zeta$函数</h2>
$\zeta(s)=\sum\limits_{i=1}^{\infty}\frac 1 {i^s} (s\in\mathbb{C})$
黎曼$\zeta$函数就是$\chi=1$时的L函数。
狄利克雷生成函数常常写成$\zeta$的表达式形式。
<h2> 见证奇迹的时刻到了！</h2>
数列对应位置相加$\to$生成函数相加
狄利克雷卷积$\to$生成函数相乘
狄利克雷卷积意义的逆元$\to$生成函数取倒数
<h2> 常见数列的生成函数</h2>
单位元$e:1$
$1:\zeta(s)$
$\mathrm{id}_k:\zeta(s-k)$
$\mu:\frac 1 {\zeta(s)}$
$\mu^2:\frac{\zeta(s)}{\zeta(2s)}$
$\phi:\frac{\zeta(s-1)}{\zeta(s)}$
$\sigma_0:\zeta(s)^2$
$\sigma_k:\zeta(s)\zeta(s-k)$
$\{a_x=[x\text{为完全平方数}]\}:\zeta(2s)$
<h2> 这里面还有更深入的理论，可是我太蒻了，不会。</h2>
虽然这只是解析数论的一点皮毛，但是它已经优美得令人折服。更可怕的是，数学家可以利用这样的数学工具，用代数手段干数论问题。
和普通生成函数对应FFT不同，狄利克雷生成函数没啥明显的算法意义。
我出门了。我好菜。
<del>不过，我会科学用OEIS了</del>
EOP
);
docfoot();
?>
