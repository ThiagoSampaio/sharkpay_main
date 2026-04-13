ewports expand in the cross axis to fill their container and '
              'constrain their children to match their extent in the cross axis. '
              'In this case, a horizontal shrinkwrapping viewport was given an '
              'unlimited amount of vertical space in which to expand.',
            );
          }
      }
      return true;
    }());
    return true;
  }

  @override
  void performLayout() {
    final BoxConstraints constraints = this.constraints;
    if (firstChild == null) {
      // Shrinkwrapping viewport only requires the cross axis to be bounded.
      assert(_debugCheckHasBoundedCrossAxis());
      size = switch (axis) {
        Axis.vertical => Size(constraints.maxWidth, constraints.minHeight),
        Axis.horizontal => Size(constraints.minWidth, constraints.maxHeight),
      };
      offset.applyViewportDime