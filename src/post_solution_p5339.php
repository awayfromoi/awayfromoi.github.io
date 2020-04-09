<!--
题解 P5339 【[TJOI2019]唱、跳、rap和篮球】
容斥，枚举k表示至少k组讨论cxk的同学，它对答案的贡献为两部分相乘：
-->
<?php
include'libs.php';
dochead("题解 P5339 【[TJOI2019]唱、跳、rap和篮球】");
auto_mk('p',<<<'EOP'
<del>鸡你太美</del>
容斥，枚举$k$表示至少$k$组讨论cxk的同学，它对答案的贡献为两部分相乘：
1. 在$n$个同学的序列中放置$k$组讨论cxk的同学，这个可以简单dp出来：$dp_{i,j}=dp_{i-1,j}+dp_{i-4,j-1}$
2. 不一定讨论cxk的同学如何排列，即从人数分别为$a-4k,b-4k,c-4k,d-4k$（以下记作$A,B,C,D$）的4组同学中选出总数为$n-4k$（以下记作$N$）的同学。
如果$A+B+C+D=N$，那么就是可重排列问题，答案为$\frac{N!}{A!B!C!D!}$。
如果$A+B+C+D>N$呢？那么我们就枚举$=N$的部分，答案为：
$\sum\limits_{i=0}^A\sum\limits_{j=0}^B\sum\limits_{k=0}^C\sum\limits_{l=0}^D[i+j+k+l=N]\frac{N!}{i!j!k!l!}$
$=N!\sum\limits_{i=0}^A\sum\limits_{j=0}^B\sum\limits_{k=0}^C\sum\limits_{l=0}^D[i+j+k+l=N]\frac 1{i!}\frac 1{j!}\frac 1{k!}\frac 1{l!}$
看到你了！卷积！
NTT
$O(n^2 log n)$
EOP
);
mk_cota('cpp',<<<'EOC'
#include<bits/stdc++.h>
#define rep(i,a,b) for(int i=(a);i<=(b);i++)
using namespace std;
typedef long long int ll;
const ll maxn=20005;
int n,a,b,c,d;const ll xrj=998244353;
ll dp[2005][2005];
ll wn[25],wn2[25];
ll ksm(ll d,ll z){
	ll ans=1;while(z){
		if(z&1)ans=ans*d%xrj;
		d=d*d%xrj;
		z>>=1;}
	return ans;}
ll r[maxn];
void ntt(ll *a,ll l,int on){
	//rep(i,0,(1<<l)-1)cout<<a[i]<<"v";;cout<<endl;
	rep(i,0,(1<<l)-1)r[i]=(r[i>>1]>>1)|((i&1)<<(l-1));
	rep(i,0,(1<<l)-1)if(i<r[i])swap(a[i],a[r[i]]);
	rep(i,0,l-1){
		int j=1<<i;
		ll x=on==-1?wn2[i+1]:wn[i+1];for(int k=0;k<1<<l;k+=j<<1){
			ll y=1;rep(m,0,j-1){
				ll p=a[k+m],q=y*a[k+j+m]%xrj;
				a[k+m]=(p+q)%xrj;
				a[k+j+m]=(p+xrj-q)%xrj;
				(y*=x)%=xrj;}}}
	if(on==-1){
		ll ny=ksm(1<<l,xrj-2);
		rep(i,0,(1<<l)-1)(a[i]*=ny)%=xrj;}
	/*rep(i,0,(1<<l)-1)cout<<a[i]<<"^";;cout<<endl;*/}
ll jc[maxn],jcny[maxn];
ll aa[maxn],bb[maxn],cc[maxn],dd[maxn];
ll work(int n,int a,int b,int c,int d){
	//cout<<"#"<<n<<" "<<a<<" "<<b<<" "<<c<<" "<<d<<endl;
	int l=0;while(1<<l<(a+b+c+d)<<1)++l;
#define haha(a,aa) rep(i,0,(1<<l)-1)aa[i]=i<=a?jcny[i]:0;
	haha(a,aa);haha(b,bb);haha(c,cc);haha(d,dd);
	ntt(aa,l,1);ntt(bb,l,1);ntt(cc,l,1);ntt(dd,l,1);
	rep(i,0,(1<<l)-1)aa[i]=aa[i]*bb[i]%xrj*cc[i]%xrj*dd[i]%xrj;
	ntt(aa,l,-1);
return aa[n]*jc[n]%xrj;}
int main(){
	cin>>n>>a>>b>>c>>d;
	rep(i,0,n)dp[i][0]=1;
	rep(i,1,n)rep(j,1,n)dp[i][j]=(dp[i-1][j]+((i>=4)?dp[i-4][j-1]:0))%xrj;
	//rep(i,1,n){rep(j,0,n)cout<<dp[i][j]<<" ";;cout<<endl;}
	rep(i,0,19)wn[i]=ksm(3,(xrj-1)>>i);
	rep(i,0,19)wn2[i]=ksm(wn[i],xrj-2);
	jc[0]=1;
	rep(i,1,4*n)jc[i]=jc[i-1]*i%xrj;
	jcny[4*n]=ksm(jc[4*n],xrj-2);
	for(int i=4*n-1;i>=0;i--)jcny[i]=jcny[i+1]*(i+1)%xrj;
	//rep(i,0,4*n)cout<<jc[i]<<" ";;cout<<endl;
	//rep(i,0,4*n)cout<<jcny[i]<<" ";;cout<<endl;
	int sgn=1;ll ans=0;
	int kk=min(n/4,min(a,min(b,min(c,d))));
	rep(k,0,kk){
		ll a1=work(n-4*k,a-k,b-k,c-k,d-k),a2=dp[n][k];
		//cout<<k<<"$"<<a1<<" "<<a2<<endl;
		(ans+=sgn*a1%xrj*a2%xrj)%=xrj;
		sgn=xrj-sgn;}
	cout<<ans<<endl;
	return 0;}
EOC
);
docfoot();
?>
