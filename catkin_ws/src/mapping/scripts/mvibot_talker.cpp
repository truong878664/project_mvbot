// lib user
#include "src/thread.h"
#include "src/libary.h"
//
using namespace  std;
using std::experimental::filesystem::path;

std::string mvibot_seri = "";
// settime process
long double ts_process1=0.1; //time set for process1
long double ts_process2=0.1; //time set for process2
// var for process
static pthread_mutex_t process_mutex=PTHREAD_RECURSIVE_MUTEX_INITIALIZER_NP;
static pthread_t p_process1;
static pthread_t p_process2;
//
void talker(){
    /**
        * NodeHandle is the main access point to communications with the ROS system.
        * The first NodeHandle constructed will fully initialize this node, and the last
        * NodeHandle destructed will close down the node.
    */
    // static ros::NodeHandle n;
    // static ros::Publisher pub = n.advertise<std_msgs::String>("/" + mvibot_seri + "/talker", 1);
    // static float creat_fun = 0;
    // static long num;
    // static std_msgs::String msg;

    // if(creat_fun == 1)
    // {   
    //     num += 1;
    //     if (num == 100) {
    //         num = 0;
    //     };
    //     // msg.data="MViBot Hello " + to_string(num);
    //     msg.data = "MVIBOT199|navigation|10|" + to_string(num) + "|1|1|0|1|" + to_string(num) + "|1|1|1" + "@" + "MVIBOT212|mapping|10|" + to_string(num) + "|1|1|0|1|" + to_string(num) + "|10|1|1|1|"
    //     + "@" + "MVIBOT216|navigation|10|" + to_string(num) + "|1|1|0|1|" + to_string(num) + "|1|1|1|" + "@" + "MVIBOT203|mapping|10|" + to_string(num) + "|1|1|0|1|" + to_string(num) + "|1|1|1" + 
    //     "@" + "MVIBOT300|navigation|10|" + to_string(num) + "|1|1|0|1|" + to_string(num) + "|1|1|1|";
    //     cout<<"Send :" + msg.data<<endl;
    //     pub.publish(msg);
    // } else creat_fun = 1;

    static ros::NodeHandle n1,n2,n3;
    static ros::Publisher iam_pub = n1.advertise<std_msgs::String>("/IAM",1);
    static ros::Publisher iam_pub1 = n2.advertise<std_msgs::String>("/IAM",1);
    static std_msgs::String iam_msg,iam_msg1;
    float r = static_cast <float> (rand()) / static_cast <float> (RAND_MAX);

    if(r>0.9) {
        iam_msg.data="MVIBOT216|navigation|12|77|1|-1|1|-1|27|9|-1|8";
        iam_msg1.data="MVIBOT212|mapping|22|50|-1|1|-1|1|33|8|1|3";
    }
    else {
        iam_msg.data="MVIBOT216|mapping|21.05|25|0|1|-1|1|29|12|1|1";
        iam_msg1.data="MVIBOT212|navigation|23.18|30|1|0|-1|0|35|15|-1|7";
    }
  
    iam_pub.publish(iam_msg);
    iam_pub1.publish(iam_msg1);

}



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
    char name[] = "Process A";
	process(name, ts_process1, 0, function1);
    void *value_return;
    return value_return;
}

void * process2(void * nothing){
	char name[] = "Process B";
	process(name, ts_process2, 1, function2);
    void *value_return;
    return value_return;
}

int main(int argc, char** argv) {
    int res;
    //
    ros::init(argc, argv, "mvibot_talker");
    ros::NodeHandle nh("~");
    nh.getParam("mvibot_seri", mvibot_seri);


    res = pthread_create(&p_process1, NULL, process1, NULL);
    //res=pthread_create(&p_process2,NULL,process2,NULL);
    printf("Done\n");
    ros::NodeHandle n1;
    //ros::Subscriber sub1 = n1.subscribe("/"+mvibot_seri+"/msg", 1, msgf);    
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
        cout<<name+"|Time:"<<std::fixed << std::setprecision(5)<<((long double)realtime.tv_sec + (long double)realtime.tv_nsec*1e-9)<<endl;
    unlock();
}

//
void function1(){
    lock();
	    printf("Action function 1\n");
        time_now("At:");
        talker();
    unlock();
}

void function2(){
    lock();
	    printf("Action function 2\n");
        time_now("At:");
    unlock();
}