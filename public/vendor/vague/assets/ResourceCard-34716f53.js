import{_ as a,o as n,c,a as e,t,n as d,e as i,w as l,d as u}from"./app-820b667c.js";const m={props:["resource"],data(){return{colors:["red","blue","indigo","green","purple"]}},computed:{color(){return this.randomColor()}},methods:{randomColor(){return this.colors[Math.round((this.colors.length-1)*Math.random())]}}},_={class:"rounded-lg bg-white border border-gray-200 shadow-sm overflow-hidden"},h={class:"text-gray-900 font-semibold"},g={class:"text-gray-600 font-medium text-sm"},f=e("div",{class:"border-t border-gray-100 text-gray-700 text-sm p-3 text-center font-medium hover:bg-gray-100 transition cursor-pointer"}," More Details.. ",-1);function p(x,b,r,y,v,o){const s=u("inertia-link");return n(),c("div",_,[e("div",{class:d(["w-full px-5 py-5 bg-gradient-to-tr",`from-${o.color}-50 to-${o.color}-100`])},[e("p",h,t(r.resource.name),1),e("p",g,t(r.resource.record_count)+" records ",1)],2),i(s,{href:`/vague/resource/${r.resource.slug}`},{default:l(()=>[f]),_:1},8,["href"])])}const C=a(m,[["render",p]]);export{C as default};
