// lib user
#include "src/thread.h"
#include "src/libary.h"
//
using namespace  std;
std::string mvibot_seri;
// settime process
long double ts_process1=0.1; //time set for process1
long double ts_process2=0.1; //time set for process2
// var for process
static pthread_mutex_t process_mutex=PTHREAD_RECURSIVE_MUTEX_INITIALIZER_NP;
static pthread_t p_process1;
static pthread_t p_process2;
//
void lock();
void unlock();
void time_now(string name);
void function1();
void function2();
//
void msgf(const std_msgs::String& msg){
	//
	lock();
		cout<<msg.data<<endl;
	//
	unlock();
}
void * process1(void * nothing){
    char name[]="Process A";
	process(name,ts_process1,0,function1);
    void *value_return;
    return value_return;
}
void * process2(void * nothing){
	char name[]="Process B";
	process(name,ts_process2,1,function2);
    void *value_return;
    return value_return;
}
int main(int argc, char** argv) {
    int res;
    //
    ros::init(argc, argv, "mvibot_common");
    ros::NodeHandle nh("~");
    nh.getParam("mvibot_seri", mvibot_seri);
    res=pthread_create(&p_process1,NULL,process1,NULL);
    res=pthread_create(&p_process2,NULL,process2,NULL);
    printf("Done\n");
    ros::NodeHandle n1;
    ros::Subscriber sub1 = n1.subscribe("/"+mvibot_seri+"/msg", 1, msgf);    
    ros::spin(); 
	return 0;
}
//
void lock(){
    pthread_mutex_lock(&process_mutex);
}
void unlock(){
    pthread_mutex_unlock(&process_mutex);
}
void time_now(string name){
    lock();
        static struct timespec realtime;
        clock_gettime(CLOCK_REALTIME, &realtime);
        cout<<name+"|Time:"<<std::fixed << std::setprecision(5)<<((long double)realtime.tv_sec+(long double)realtime.tv_nsec*1e-9)<<endl;
    unlock();
}
//
void function1(){
    lock();
	    printf("Action function 1\n");
        time_now("At:");
    unlock();
}
void function2(){
    lock();
	    printf("Action function 2\n");
        time_now("At:");
    unlock();
}