#!/usr/bin/env python3
import rospy 

if __name__ == '__main__':
    rospy.init_node("test_node")

    rospy.loginfo("Hello from test node")
    rospy.logwarn("This is a warning message")
    rospy.logerr("This is a error message")

    rospy.sleep(1)

    rospy.loginfo("End of program")