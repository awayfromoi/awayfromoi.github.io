<!--
题解 P4137 【Rmq Problem / mex】
我们考虑莫队的做法。如果我们删除一个数，那么用被删的数更新mex即可。如果加入一个数，似乎比较麻烦（至少本蒟蒻没想出来）。
-->
<?php
include'libs.php';
dochead("题解 P4137 【Rmq Problem / mex】");
auto_mk('p',<<<'EOP'
我们考虑莫队的做法。如果我们删除一个数，那么用被删的数更新mex即可。如果加入一个数，似乎比较麻烦（至少本蒟蒻没想出来）。
于是我们借鉴回滚莫队的思想，写出只需删除不需插入的莫队。
大于n的数对答案无影响，在处理时可以直接忽略。
EOP
);
mk_cota('cpp',<<<'EOC'
// luogu-judger-enable-o2
#include<bits/stdc++.h>
#define rep(i,a,b) for(int i=a;i<=b;i++)
using namespace std;
const int maxn=2e+5+5;
int n,m,ksiz;
int aa[maxn];
int bb[maxn];
int bl[maxn];
//unordered_map<int,int> se;
//unordered_map<int,int> se2;
int se[maxn],se2[maxn];
int ans=0,ans2=0,ans3=0;
struct query{
    int l;
    int r;
    int ans;
    int id;
}qq[maxn];
bool operator <(query x,query y){
    return bl[x.l]==bl[y.l]?x.r>y.r:bl[x.l]<bl[y.l];
}
int cnt=0;
void add(int pos){
    cnt++;
    if(aa[pos]>n+1)return;
    se[aa[pos]]++;
}
void del(int pos,int &myans){
    cnt++;
    if(aa[pos]>n+1)return;
    se[aa[pos]]--;
    if(se[aa[pos]]==0)myans=min(myans,aa[pos]);
}
int res[maxn];
int main(){
    scanf("%d%d",&n,&m);
    rep(i,1,n)scanf("%d",aa+i),bb[i]=aa[i];
    sort(bb+1,bb+n+1);
    rep(i,1,n)if(bb[i]==ans)ans++;
    ksiz=sqrt(n);
    rep(i,1,n)bl[i]=(i-1)/ksiz*ksiz+1;
    rep(i,1,m)scanf("%d%d",&qq[i].l,&qq[i].r);
    rep(i,1,m)qq[i].id=i;
    sort(qq+1,qq+m+1);
    int l=1,r=n;
    rep(i,1,n)se[aa[i]]++;
    ans2=ans;
    rep(i,1,m){
        if(bl[qq[i].l]==bl[qq[i].r]){
            rep(j,qq[i].l,qq[i].r)if(aa[j]<=n+1)se2[aa[j]]++;
            qq[i].ans=0;
            while(se2[qq[i].ans])qq[i].ans++;
            rep(j,qq[i].l,qq[i].r)if(aa[j]<=n+1)se2[aa[j]]--;
            continue;
        }
        while(l<bl[qq[i].l]){
            while(r<n)add(++r); //restore right
            del(l++,ans); //move kuai
            ans2=ans;
        }
        while(r>qq[i].r)del(r--,ans2); //move right
        ans3=ans2;
        int lpie=l;
        while(lpie<qq[i].l)del(lpie++,ans3);
        while(lpie>l)add(--lpie);
        qq[i].ans=ans3;
    }
    rep(i,1,m)res[qq[i].id]=qq[i].ans;
    rep(i,1,m)printf("%d\n",res[i]);
    //cout<<cnt<<endl;
    return 0;
}
EOC
);
docfoot();
?>
