<!--
题解 P3901 【数列找不同】
这题没人用st表吗？我发一个st表的题解。 预处理出每一个数在数列中出现的上一个位置（特别的，第一次出现的数，上一个位置为0）。 那么，一段区间[L,R]的数不重复，当且近当每一个数出现的上一个位置小于L，即数出现的上一个位置的最大值小于L。 于是我们可以用st表处理出区间最大值。
-->
<?php
include'libs.php';
dochead("题解 P3901 【数列找不同】");
auto_mk('p',<<<'EOP'
这题没人用st表吗？我发一个st表的题解。 预处理出每一个数在数列中出现的上一个位置（特别的，第一次出现的数，上一个位置为0）。 那么，一段区间[L,R]的数不重复，当且近当每一个数出现的上一个位置小于L，即数出现的上一个位置的<strong>最大值</strong>小于L。 于是我们可以用st表处理出区间最大值。
EOP
);
mk_cota('cpp',<<<'EOC'
#include<bits/stdc++.h>
#define rep(i,a,b) for(int i=a;i<=b;i++)
using namespace std;
int n,q;
int aa[100005];
int ton[100005];
int st[20][100005];
int main(){
	scanf("%d%d",&n,&q);
	rep(i,1,n)scanf("%d",aa+i);
	rep(i,1,n){
		st[0][i]=ton[aa[i]];
		ton[aa[i]]=i;
	}
	rep(i,1,19)rep(j,1,(n-(1<<i)+1))
		st[i][j]=max(st[i-1][j],st[i-1][j+(1<<i-1)]);
	rep(i,0,19){
	//	rep(j,1,(n-(1<<i)+1))cout<<st[i][j]<<" ";;cout<<endl;
	}
	rep(i,1,q){
		int l,r;scanf("%d%d",&l,&r);
		int d=31-__builtin_clz(r-l+1);
		int ans=max(st[d][l],st[d][r-(1<<d)+1]);
		if(ans>=l)printf("No\n");else printf("Yes\n");
	}
	return 0;
}
EOC
);
docfoot();
?>
