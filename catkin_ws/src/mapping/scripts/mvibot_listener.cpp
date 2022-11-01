// lib user
#include "src/thread.h"
#include "src/libary.h"
//
using namespace  std;
std::string mvibot_seri_MVIBOT203 = "MVIBOT203/wifiConnect";
std::string mvibot_seri_MVIBOT212 = "MVIBOT212/wifiConnect";
std::string mvibot_seri_MVIBOT216 = "MVIBOT216/wifiConnect";

std::string mvibot_seri_MVIBOT203_ethernet = "MVIBOT203/ethernet";
std::string mvibot_seri_MVIBOT212_ethernet = "MVIBOT212/ethernet";
std::string mvibot_seri_MVIBOT216_ethernet = "MVIBOT216/ethernet";

std::string mvibot_seri_MVIBOT203_mission = "MVIBOT203/mission";
std::string mvibot_seri_MVIBOT212_mission = "MVIBOT212/mission";
std::string mvibot_seri_MVIBOT216_mission = "MVIBOT216/mission";

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
void listener(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}

void listener1(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}

void listener2(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}

void listener3(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}

void listener4(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}


void listener5(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}


void listener6(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}


void listener7(const std_msgs::String& msg){
	//
	lock();
        time_now("At:");
		cout<<msg<<endl;
	//
	unlock();
}
//
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
    ros::init(argc, argv, "mvibot_listener");
    ros::NodeHandle nh("~"); 
    nh.getParam("mvibot_seri_MVIBOT203", mvibot_seri_MVIBOT203);
    nh.getParam("mvibot_seri_MVIBOT212", mvibot_seri_MVIBOT212);
    nh.getParam("mvibot_seri_MVIBOT216", mvibot_seri_MVIBOT216);

    nh.getParam("mvibot_seri_MVIBOT203_ethernet", mvibot_seri_MVIBOT203_ethernet);
    nh.getParam("mvibot_seri_MVIBOT212_ethernet", mvibot_seri_MVIBOT212_ethernet);
    nh.getParam("mvibot_seri_MVIBOT216_ethernet", mvibot_seri_MVIBOT216_ethernet);

    nh.getParam("mvibot_seri_MVIBOT203_mission", mvibot_seri_MVIBOT203_mission);
    nh.getParam("mvibot_seri_MVIBOT212_mission", mvibot_seri_MVIBOT212_mission);
    nh.getParam("mvibot_seri_MVIBOT216_mission", mvibot_seri_MVIBOT216_mission);


    //res=pthread_create(&p_process1,NULL,process1,NULL);
    //res=pthread_create(&p_process2,NULL,process2,NULL);
    printf("Done\n");
    ros::NodeHandle n1,n2,n3,n4,n5,n6,n7,n8,n9;
    ros::Subscriber sub1 = n1.subscribe("/" + mvibot_seri_MVIBOT203, 1, listener1);    
    ros::Subscriber sub2 = n2.subscribe("/" + mvibot_seri_MVIBOT212, 1, listener);  
    ros::Subscriber sub3 = n3.subscribe("/" + mvibot_seri_MVIBOT216, 1, msgf); 
    ros::Subscriber sub4 = n4.subscribe("/" + mvibot_seri_MVIBOT203_ethernet, 1, listener2);    
    ros::Subscriber sub5 = n5.subscribe("/" + mvibot_seri_MVIBOT212_ethernet, 1, listener3);  
    ros::Subscriber sub6 = n6.subscribe("/" + mvibot_seri_MVIBOT216_ethernet, 1, listener4);    
    ros::Subscriber sub7 = n7.subscribe("/" + mvibot_seri_MVIBOT203_mission, 1, listener5);    
    ros::Subscriber sub8 = n8.subscribe("/" + mvibot_seri_MVIBOT212_mission, 1, listener6);  
    ros::Subscriber sub9 = n9.subscribe("/" + mvibot_seri_MVIBOT216_mission, 1, listener7);    
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